<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\FormSubmission;
use App\Models\Page;
use App\Models\ThemeTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FormController extends Controller
{
    public function submit(Request $request)
    {
        $formName = trim((string) $request->input('_form_name', ''));
        $sourceUrl = (string) $request->input('_source_url', '');
        if ($formName === '') {
            abort(422, 'form_name missing');
        }

        $widget = $this->findFormWidget($formName);
        if (! $widget) {
            abort(404, 'form not found');
        }

        $fields = $widget['props']['fields'] ?? [];
        $rules = [];
        $data = [];
        foreach ($fields as $f) {
            $name = $f['name'] ?? null;
            if (! $name) {
                continue;
            }
            $type = $f['type'] ?? 'text';
            $required = ! empty($f['required']);
            $r = [$required ? 'required' : 'nullable'];
            if ($type === 'email') {
                $r[] = 'email';
            } elseif ($type === 'tel') {
                $r[] = 'string';
                $r[] = 'max:40';
            } elseif ($type === 'checkbox') {
                $r = [$required ? 'accepted' : 'nullable'];
            } else {
                $r[] = 'string';
                $r[] = 'max:5000';
            }
            $rules[$name] = implode('|', $r);
            $data[$name] = $request->input($name);
        }
        $validated = $request->validate($rules);

        $emailFromData = null;
        foreach ($fields as $f) {
            if (($f['type'] ?? null) === 'email' && isset($data[$f['name']])) {
                $emailFromData = $data[$f['name']];
                break;
            }
        }

        $submission = FormSubmission::create([
            'form_name' => $formName,
            'source_url' => substr($sourceUrl, 0, 255),
            'data' => $data,
            'email' => $emailFromData,
            'ip' => $request->ip(),
            'user_agent' => substr((string) $request->userAgent(), 0, 500),
        ]);

        $emailTo = $widget['props']['email_to'] ?? null;
        if ($emailTo) {
            try {
                Mail::raw($this->formatEmailBody($formName, $data, $sourceUrl), function ($m) use ($emailTo, $formName) {
                    $m->to($emailTo)->subject('Nuevo envío del formulario '.$formName);
                });
            } catch (\Throwable $e) {
                report($e);
            }
        }

        $success = $widget['props']['success_message'] ?? 'Gracias, te responderemos pronto.';

        if ($request->wantsJson()) {
            return response()->json(['ok' => true, 'message' => $success]);
        }

        return redirect($sourceUrl ?: url()->previous())->with('form_success.'.$formName, $success);
    }

    protected function findFormWidget(string $formName): ?array
    {
        foreach (Page::whereNotNull('blocks')->cursor() as $page) {
            $widget = $this->searchBlocksForForm($page->blocks ?? [], $formName);
            if ($widget) {
                return $widget;
            }
        }
        foreach (ThemeTemplate::whereNotNull('blocks')->cursor() as $tpl) {
            $widget = $this->searchBlocksForForm($tpl->blocks ?? [], $formName);
            if ($widget) {
                return $widget;
            }
        }

        return null;
    }

    protected function searchBlocksForForm(array $blocks, string $formName): ?array
    {
        foreach ($blocks as $section) {
            foreach ($section['columns'] ?? [] as $col) {
                foreach ($col['widgets'] ?? [] as $w) {
                    if (($w['type'] ?? '') === 'form' && ($w['props']['form_name'] ?? '') === $formName) {
                        return $w;
                    }
                }
            }
        }

        return null;
    }

    protected function formatEmailBody(string $formName, array $data, string $sourceUrl): string
    {
        $lines = ["Formulario: {$formName}", "URL: {$sourceUrl}", ''];
        foreach ($data as $k => $v) {
            $lines[] = $k.': '.(is_scalar($v) ? $v : json_encode($v));
        }

        return implode("\n", $lines);
    }
}
