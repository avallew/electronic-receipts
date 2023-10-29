<?php

namespace App\Services;

use App\Jobs\SendEmailCompanyCreatedJob;
use App\Jobs\SendEmailElectroniReceiptCreatedJob;
use App\Mail\ElectronicReceiptCreatedMailable;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    protected $notificationEmailType = 'EMAIL';
    protected $typeNotificationCompanyCreated = 'CompanyCreated';
    protected $typeNotificationElectronicReceiptCreated = 'ElectronicReceiptCreated';
    protected $typeNotificationDeleteDataFromCompany = 'DeleteDataFromCompany';
    protected $notificationSmsType = 'SMS';

    public function sendNotification($request)
    {
        $notificationType = $request->typeNotification;
        $data = $request->data;
        if ($notificationType['type'] == $this->notificationEmailType) {
            if ($notificationType['emailType'] == $this->typeNotificationCompanyCreated) {
                return $this->sendEmailNotificationCompanyCreated(
                    $request->data->user_id,
                    $request->data->email,
                    $request->data->commercialname,
                    $request->data->username,
                    $request->data->password,
                    $request->data->domain,
                    $request->data->color
                );
            } else if ($notificationType['emailType'] == $this->typeNotificationElectronicReceiptCreated) {
                return $this->sendEmailNotificationElectronicReceiptCreated(
                    $request->data->email,
                    $request->data->client_name,
                    $request->data->electronic_receipt_type,
                    $request->data->document_name_emissor,
                    $request->data->document_number,
                    $request->data->total,
                    'dasdas',
                    'fdsfds'
                );
            }
            // else
            // return $this->notificationService->sendSmsNotification($data);
        } else if ($notificationType['type'] == $this->notificationSmsType) {
            if ($notificationType['smsType'] == $this->typeNotificationCompanyCreated) {
                $notificationService = new NotificationService();
                return $notificationService->sendSmsNotificationCompanyCreated($data);
            }
        }
    }

    public function sendEmailNotificationCompanyCreated($email, $commercialname, $username, $password_user, $domain, $color, $token)
    {
        $dataToSendEmailNotificationCompanyCreated = [
            'token' => $token,
            'email' => $email,
            'comercialName' => $commercialname,
            'username' => $username,
            'password' => $password_user,
            'color' => $color,
            'url' => $domain,
        ];
        SendEmailCompanyCreatedJob::dispatch($dataToSendEmailNotificationCompanyCreated)->onQueue('SendEmailCompanyCreated');
    }

    public function sendEmailNotificationElectronicReceiptCreated(
        $data,
        $electronic_receipt_type_spanish,
        $client_name,
        $document_emissor_name,
        $total,
        $electronic_receipt_folder_xml,
        $document_pdf_type
    ) {
        $document_number = $data->infoTributaria->estab . '-' . $data->infoTributaria->ptoEmi . '-' . $data->infoTributaria->secuencial;

        $dataToSendEmailNotificationElectronicReceiptCreated = [
            'document_xml_path' => storage_path('app/public/' . $electronic_receipt_folder_xml . '/' . $document_number . '.xml'),
            'email' => $data->email,
            'client_name' => $client_name,
            'electronic_receipt_type_spanish' => $electronic_receipt_type_spanish,
            'document_emissor_name' => $document_emissor_name,
            'document_number' => $document_number,
            'total' => $total,
            'document_pdf_type' => $document_pdf_type,
            'data_for_pdf' => $data
        ];

        // $email = new ElectronicReceiptCreatedMailable(
        //     $dataToSendEmailNotificationElectronicReceiptCreated['document_path'],
        //     $dataToSendEmailNotificationElectronicReceiptCreated['client_name'],
        //     $dataToSendEmailNotificationElectronicReceiptCreated['electronic_receipt_type'],
        //     $dataToSendEmailNotificationElectronicReceiptCreated['document_name_emissor'],
        //     $dataToSendEmailNotificationElectronicReceiptCreated['document_number'],
        //     $dataToSendEmailNotificationElectronicReceiptCreated['total'],
        //     $dataToSendEmailNotificationElectronicReceiptCreated['pdf_path']
        // );
        // Mail::to($dataToSendEmailNotificationElectronicReceiptCreated['email'])->send($email);

        SendEmailElectroniReceiptCreatedJob::dispatch($dataToSendEmailNotificationElectronicReceiptCreated)->onQueue('SendEmailElectronicReceiptCreated');
    }

    public function sendSmsNotificationCompanyCreated($request)
    {
        return 'sms';
    }
}
