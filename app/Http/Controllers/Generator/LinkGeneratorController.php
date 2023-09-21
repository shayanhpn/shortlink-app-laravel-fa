<?php

namespace App\Http\Controllers\Generator;

use App\Models\Link;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class LinkGeneratorController extends Controller
{
    public function generateLink(Request $request){
        $linkFields = $request->validate([
            'sourceLink' => ['required','url:http,https,ftp'],
            'captcha' => ['required','captcha']
        ],[
            'sourceLink.required' => 'وارد کردن لینک الزامی است',
            'sourceLink.url' => 'لطفا آدرس اینترنتی صحیح را با رعایت پروتکل  وارد نمایید...مثال: https://google.com',
            'captcha.required' => 'وارد کردن کد امنیتی الزامی است',
            'captcha.captcha' => 'لطفا کد امنیتی صحیح را وارد کنید'
        ]);


        $link = new Link;
        $link->source_link = $linkFields['sourceLink'];
        $link->destination_link = Link::genRandomStr();
        $link->user_id = auth()->user()->id;
        $link->save();
        return view('main.result',['dest' => $link->destination_link]);
    }
}