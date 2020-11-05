<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Email;
use Mail;
use Illuminate\Support\Facades\DB;
class EmailController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');    
        
        $buscar = $request->buscar;
        $criterio = $request->criterio;

        if ($buscar==''){
            $email = Email::all();
        }
        else{
            $email = Email::where($criterio, 'like', '%'. $buscar . '%')
                        ->orderBy('created_at', 'desc')
                        ->get();
        }

        return response()->json(['emails' => $email]);
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');    
        
        try{
            DB::beginTransaction();

            $mail = new Email();
            $mail->nombre = $request->nombre;
            $mail->email = $request->email;
            $mail->telefono = $request->telefono;
            $mail->asunto = $request->asunto;
            $mail->activo = 1;
            $mail->save();

            $data = Email::where('id',$mail->id)->first()->toArray();
            
            Mail::send('correo.plantilla', $data, function ($message) use($mail)  {
                $message->from('notificaciones@giroweb.com.mx');
                $message->subject('Nuevo correo de contactanos'); 
                $message->to($mail->email);        
            });   

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }
}
