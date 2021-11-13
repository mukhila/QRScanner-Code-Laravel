<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Use App\Models\qrdetails;
Use App\qrscannerdetails;
use Symfony\Component\HttpFoundation\Session\Session;
//use Session;
use QrCode;

class QrCodeController extends Controller
{
    public function index(Request $request)
    {	
		$qrdetails = new qrscannerdetails;
		$qrdetails->companyname = $request->companyname;
		$qrdetails->websiteurl = $request->geturl;
		$qrtext = $request->geturl;
		$qrsize = 300;
		$img =  base64_encode(QrCode::format('png')->size($qrsize)->errorCorrection('H')->margin(0)->generate($qrtext));
		$data = base64_decode($img);
		$randnum = rand(10000,99999).'-'.date('YmdHis');
		$file = $_SERVER['DOCUMENT_ROOT'].'/assets/companyqrcodes/'.$randnum.'.png';	
		file_put_contents($file, $data);
		$qrdetails->imagepath = 	$randnum.'.png';
		$qrdetails->save();	
	    //return view('qrcode',compact('qrdetails'));
		return redirect('/Qrcodeview')->with('success', ' QRCode Successfully Created!');
    }
	public function Qrcodeview()
	{
		$qrdetails = qrscannerdetails::all();      
        return view('qrcode',compact('qrdetails'));
	}
}
