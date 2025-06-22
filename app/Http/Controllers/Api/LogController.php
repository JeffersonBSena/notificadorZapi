<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log as Logger;
use App\Models\Log as LogModel;

class LogController extends Controller
{
    public function store(Request $request)
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!is_array($data)) {
                throw new \Exception('Corpo JSON inválido: ' . $request->getContent());
            }

            $logDescription = strtoupper($data['log'] ?? '');
            $typeLog = strtoupper($data['type_log'] ?? '');

            $log = LogModel::create([
                'source' => $data['source'] ?? null,
                'type_log' => $typeLog,
                'log' => $logDescription,
                'textobs' => $data['textobs'] ?? null,
                'timestamp' => now(),
            ]);

            Logger::info('Log salvo no banco', [
                'id' => $log->id,
                'type_log' => $typeLog,
            ]);

            if ($typeLog === 'CRITICAL') {
                Logger::info('Disparando WhatsApp ALERTA CRITICAL...');
                $this->sendWhatsAppAlert($log);
            }

            return response()->json([
                'message' => 'Log saved',
                'id' => $log->id,
            ]);
        } catch (\Throwable $e) {
            Logger::error('Erro no store(): ' . $e->getMessage());
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function sendWhatsAppAlert(LogModel $log)
    {
        $instanceUrl = config('services.zapi.url');
        $clientToken = config('services.zapi.token');
        $phones = [
            config('services.zapi.phone1'),
            config('services.zapi.phone2'),
            config('services.zapi.phone3'),
            config('services.zapi.phone4'),
            config('services.zapi.phone5'),
        ];

        Logger::info('>>> ENVIANDO ALERTA - Config', [
            'url' => $instanceUrl,
            'token' => $clientToken,
            'phones' => $phones
        ]);

        $message = "🚨 *ALERTA CRÍTICO: COLABORADOR SEM MOVIMENTO DETECTADO!*\n\n"
            . "Um colaborador dentro da câmara frigorífica parou de se mover. "
            . "Verifique imediatamente o estado de saúde e segurança.\n\n"
            . "📍 Origem: {$log->source}\n"
            . "🕒 Horário: {$log->created_at}\n"
            . "📋 Log: {$log->log}\n"
            . "📝 Observação: {$log->textobs}\n\n"
            . "EQUIPE DE PROJETO IOT - ESTACIO.";

        foreach ($phones as $phone) {
            if ($phone) {
                Logger::info('>>> Enviando para Z-API', ['phone' => $phone]);

                $response = Http::withHeaders([
                    'Client-Token' => $clientToken,
                ])->post($instanceUrl, [
                    'phone' => $phone,
                    'message' => $message,
                ]);

                Logger::info('>>> PHONES FINAL', [
                    'phones' => $phones
                ]);

                Logger::info('>>> ZAPI RESPONSE', [
                    'phone' => $phone,
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);
            }
        }
    }
}