<?php
namespace App\Http\Controllers;
use App\Models\QuoteRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data=$request->validate(['name'=>'required|string|max:120','mobile'=>'required|string|max:20','product_name'=>'nullable|string|max:160','amount'=>'nullable|numeric|min:0','city'=>'nullable|string|max:100']);
        QuoteRequest::create($data + ['status'=>'new']);
        return back()->with('success','درخواست شما ثبت شد؛ کارشناسان فولادینو با شما تماس می‌گیرند.');
    }
}
