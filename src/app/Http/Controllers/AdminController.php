<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $q = Contact::query()->with('category');

        if ($request->filled('word')) {
            $kw = trim((string) $request->input('word'));


            $kw = preg_replace('/\x{3000}/u', ' ', $kw);
            $kw = preg_replace('/\s+/u', ' ', $kw);

            $tokens = preg_split('/\s/u', $kw, -1, PREG_SPLIT_NO_EMPTY);

            $q->where(function ($sub) use ($kw, $tokens) {
                $sub->where('email', 'like', "%{$kw}%")
                    ->orWhere('last_name', 'like', "%{$kw}%")
                    ->orWhere('first_name', 'like', "%{$kw}%");

                if (count($tokens) >= 2) {
                    $last  = $tokens[0];
                    $first = $tokens[1];
                    $sub->orWhere(function ($ss) use ($last, $first) {
                        $ss->where('last_name', 'like', "%{$last}%")
                            ->where('first_name', 'like', "%{$first}%");
                    });
                }
            });
        }

        if ($request->filled('gender')) {
            $q->where('gender', (int) $request->input('gender'));
        }

        if ($request->filled('category')) {
            $q->where('category_id', (int) $request->input('category'));
        }

        if ($request->filled('date')) {
            $q->whereDate('created_at', (string) $request->input('date'));
        }

        $perPage = (int) $request->input('per_page', 7);
        $perPage = max(1, min($perPage, 100));

        $contacts = $q->orderByDesc('id')
                ->paginate($perPage)
                ->withQueryString();

        return view('auth.admin', compact('contacts'));
    }

    public function export(Request $request)
    {
        $q = Contact::query()->with('category');

    if ($request->filled('word')) {
            $kw = trim((string) $request->input('word'));
        $kw = preg_replace('/\x{3000}/u', ' ', $kw);
        $kw = preg_replace('/\s+/u', ' ', $kw);
        $tokens = preg_split('/\s/u', $kw, -1, PREG_SPLIT_NO_EMPTY);

        $q->where(function ($sub) use ($kw, $tokens) {
            $sub->where('email', 'like', "%{$kw}%")
                ->orWhere('last_name', 'like', "%{$kw}%")
                ->orWhere('first_name', 'like', "%{$kw}%");

            if (count($tokens) >= 2) {
                $last  = $tokens[0];
                $first = $tokens[1];
                $sub->orWhere(function ($ss) use ($last, $first) {
                    $ss->where('last_name', 'like', "%{$last}%")
                        ->where('first_name', 'like', "%{$first}%");
                });
            }
        });
    }

        if ($request->filled('gender')) {
        $q->where('gender', (int) $request->input('gender'));
    }

    if ($request->filled('category')) {
        $q->where('category_id', (int) $request->input('category'));
    }

    if ($request->filled('date')) {
        $q->whereDate('created_at', (string) $request->input('date'));
    }

        $q->orderByDesc('id');

        $filename = 'contacts_'.now()->format('Ymd_His').'.csv';
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

    return response()->streamDownload(function () use ($q) {
        $out = fopen('php://output', 'w');
        fwrite($out, "\xEF\xBB\xBF");

        fputcsv($out, ['お名前','性別','メール','電話','住所','建物名','お問い合わせの種類','お問い合わせ内容','受付日時']);

        $q->chunk(500, function ($rows) use ($out) {
            foreach ($rows as $c) {
                fputcsv($out, [
                    $c->full_name,
                    $c->gender_label,
                    $c->email,
                    $c->tel,
                    $c->address,
                    $c->building,
                    $c->category_name,
                    $c->detail,
                    optional($c->created_at)->format('Y-m-d H:i'),
                ]);
            }
        });

            fclose($out);
        }, $filename, $headers);
    }

    public function destroy(Request $request, Contact $contact)
    {
        $contact->delete();

        if ($back = $request->input('back')) {
            return redirect($back)->with('status', '削除しました。');
        }

        return redirect()->route('admin.index')->with('status', '削除しました。');
    }
}


