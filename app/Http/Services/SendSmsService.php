<?php

namespace App\Http\Services;
use App\Models\SmsCodes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleXMLElement;
use Exception;


class SendSmsService
{

    private string $url = 'https://smspro.nikita.kg/api/message';

    private string $login = '1bonus';
    private string $pwd = 'R7dMAE7Y';

    /**
     * @throws Exception
     */
    public function sendSms(Request $request, $type){

        $sms_id = Str::random(8);
        $code = rand(999,9999);
        $test_array = array(
            'login' => $this->login,
            'pwd' => $this->pwd,
            'id' => $sms_id,
            'sender' => 'SMSPRO.KG',
            'text' => 'Код для подтверждение: '. $code,
            'phones' => [
                'phone' => '996504111504' //change later $request->phone
            ],
            'test' => 1
        );



        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><message/>');
        $this->to_xml($xml, $test_array);
        $data = $xml->asXML();

        $curl = curl_init($this->url);

        curl_setopt ($curl, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));

        curl_setopt($curl, CURLOPT_POST, true);

        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);

        if(curl_errno($curl)){
            throw new Exception(curl_error($curl));
        }

        curl_close($curl);

        $response = $this->to_array($result);

        $createData = [
            'service_sms_id' => $sms_id,
            'phone' => $request->get('phone'),
            'code' => $code,
            'type' => $type,
            'verified' => false,
            'status' => 'sent',
        ];

        if ($response['status'] != 0){

            if ($response['status'] == 11){
                $this->createSms($createData);
                return true;
            }
            $createData['status'] = 'not_sent';
            $this->createSms($createData);
            return false;
        }

        $this->createSms($createData);
        return true;

    }




    public function createSms($data){
        SmsCodes::query()->create($data);
    }

    public function to_array($xml_string){
        $xml = simplexml_load_string($xml_string, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        return json_decode($json,TRUE);
    }
    public function to_xml(SimpleXMLElement $object, array $data)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $new_object = $object->addChild($key);
                $this->to_xml($new_object, $value);
            } else {
                // if the key is an integer, it needs text with it to actually work.
                if ($key != 0 && $key == (int) $key) {
                    $key = "key_$key";
                }

                $object->addChild($key, $value);
            }
        }
    }

}
