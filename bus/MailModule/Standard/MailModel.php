<?php

namespace Bus\MailModule\Models\Standard;

use Nette\Mail\Message;

/**
 * Description of MailModel
 *
 * @author viky
 */
class MailModel {

    use \Nette\SmartObject;

    /**
     * @var \Arit\Flexibee\Model\ObjFlexibee
     */
    protected $flexibee;

    /**
     *
     * @var array
     */
    protected $mailerConfig;

    /**
     * @var string
     */
    protected $firma;

    /**
     *
     * @var array
     */
    protected $imapConfig;

    public function __construct(\Arit\Flexibee\Model\ObjFlexibee $flexibee, array $mailerConfig, string $firma, array $imapConfig) {
        $this->flexibee = $flexibee;
        $this->mailerConfig = $mailerConfig;
        $this->firma = $firma;
        $this->imapConfig = $imapConfig;
    }

    /**
     * @param string $idFirmy
     * @return array
     */
    public function getEmails($idFirmy, $evidence, $idDokl, $user) {
        $kontakty = [];
        $adresy= [];
        $results = $this->flexibee->get('kontakt', ['firma' => $idFirmy], [
            'detail' => ['email', 'jmeno', 'prijmeni'],
            'limit' => 0,
        ]);
        foreach ($results as $line) {
            if (!empty($line['email'])) {
                $adresy[] = [
                    'email' => $line['email'],
                    'jmeno' => ($line['jmeno'] ?? "") . ' ' . ($line['prijmeni'] ?? ""),
                ];
            }
        }
        $emailStredisko = $this->flexibee->get($evidence, $idDokl, [
                    'includes' => "/$evidence/stredisko/",
                    'detail' => ['stredisko(email)']
                ])[0]['stredisko'][0]['email'];
        return [
            'recipient' => $adresy,
            'copy' => [$emailStredisko]
        ];
    }

    public function sendEmail(array $values, $blob = null, $user, $attachName) {
        $message = new Message();
        if (!empty($blob)) {
            file_put_contents('../temp/' . $attachName . '.pdf', $blob->getBody());
            $message->addAttachment('../temp/' . $attachName . '.pdf');
        }
        if (filter_var($user->getIdentity()->getData()['kontakt']['username'], FILTER_VALIDATE_EMAIL)) {
            $this->mailerConfig['from'] = $user->getIdentity()->getData()['kontakt']['username'];
        } else if (filter_var($user->getIdentity()->getData()['firma']['email']??'', FILTER_VALIDATE_EMAIL)) {
            $this->mailerConfig['from'] = $user->getIdentity()->getData()['firma']['email'];
        }
        $message->setFrom($this->mailerConfig['from']);
        foreach (explode(',', $values['to']) as $to) {
            if (!empty($to)) {
                $message->addTo(trim($to));
            }
        }

        if (!empty($values['cc'])) {
            $arr = explode(',', $values['cc']);
            foreach ($arr as $mail) {
                if (!empty($mail))
                    $message->addCc(trim($mail));
            }
        }
        /*
        if ($values['attachment']->hasFile()) {
            $message->addAttachment($values['attachment']);
        }
        */
        if ($values['attachment']->hasFile()) {
            $message->addAttachment($values['attachment']->getSanitizedName(), $values['attachment']->getContents());
        }
        $message->setSubject($values['subject']);
        $message->setHtmlBody($values['body']);

        if (isset($user->getIdentity()->getData()['kontakt']['id'])) {
            //$data = $this->users->getOne($user->getIdentity()->getData()['kontakt']['id']);

            $data = $this->flexibee->get('kontakt', $user->getIdentity()->getData()['kontakt']['id'], [
                'detail' => 'full',
                'relations' => 'prilohy'
            ])[0] ?? [];
        } else {
            $data = [];
        }

        if ($this->imapConfig['use'] && isset($data["popis"])) {
            $data= json_decode($data["popis"], true);
            if (isset($data["imapserv"]) && isset($data["imapport"]) && isset($data["imapsifr"]) && isset($data["imapfold"]) && isset($data["imapname"]) && isset($data["imappass"])) {
                if (!empty($data["imapserv"]) && !empty($data["imapport"]) && !empty($data["imapsifr"]) && !empty($data["imapfold"]) && !empty($data["imapname"]) && !empty($data["imappass"])) {
                    // Store the cipher method
                    $ciphering = $this->imapConfig['ciphering'];
                    // Use OpenSSl Encryption method
                    $iv_length = openssl_cipher_iv_length($ciphering);
                    $options = 0;
                    // Non-NULL Initialization Vector for decryption
                    $decryption_iv = $this->imapConfig['vector'];
                    // Store the decryption key
                    $decryption_key = $this->imapConfig['key'];
                    // Use openssl_decrypt() function to decrypt the data
                    $data['imappass'] = openssl_decrypt($data['imappass'], $ciphering, $decryption_key, $options, $decryption_iv);
                    $imap = imap_open("{{$data['imapserv']}:{$data['imapport']}/{$data['imapsifr']}}{$data['imapfold']}", $data['imapname'], $data['imappass']);
                    $check = imap_check($imap);
                    //bdump($check);
                    //bdump($message->generateMessage());
                    imap_append($imap, "{{$data['imapserv']}:{$data['imapport']}/{$data['imapsifr']}}{$data['imapfold']}", $message->generateMessage());
                    $check = imap_check($imap);
                    //bdump($check);
                    imap_close($imap);
                }
            }
        }

        $mailer = new \Nette\Mail\SmtpMailer($this->mailerConfig);
        $mailer->send($message);
    }

    public function sendTestEmail ($data) {
        $message = new Message();
        $message->setFrom($this->mailerConfig['from']);
        $message->addTo($data['imaptest']);
        $message->setSubject("Testovací zpráva");
        $message->setHtmlBody("Dobrý den, <br><br>toto je testovací zpráva, která je uložena také ve Vaší emailové schránce.<br><br>Váš Arit");
        //bdump($data, "imap");
        //die;
        $imap = imap_open("{{$data['imapserv']}:{$data['imapport']}/{$data['imapsifr']}}{$data['imapfold']}", $data['imapname'], $data['imappass']);
        $check = imap_check($imap);
        //bdump($check);
        //bdump($message->generateMessage());
        imap_append($imap, "{{$data['imapserv']}:{$data['imapport']}/{$data['imapsifr']}}{$data['imapfold']}", $message->generateMessage());
        $check = imap_check($imap);
        //bdump($check);
        imap_close($imap);
        $mailer = new \Nette\Mail\SmtpMailer($this->mailerConfig);
        $mailer->send($message);
        //die;
    }

    /**
     * @param string $evidence
     * @param mixed $id unique Flexibee identifier
     */
    public function getPdf(string $evidence, $id) {
        $pdf = $this->flexibee->getRaw("{$evidence}/{$id}.pdf");
        return $pdf;
    }

    public function getSubject($id, $evidence) {
        $kod = $this->flexibee->get($evidence, $id, ['detail' => ['kod']])[0]['kod'];
        $translate = [
            'nabidka-vydana' => 'Nabídka',
            'objednavka-prijata' => 'Objednávka',
            'faktura-vydana' => 'Faktura'
        ];
        return "$translate[$evidence] $kod od společnosti " .  $this->firma;
    }

    public function getAttachmentName($id, $evidence) {
        if ($id && $evidence) {
            return str_replace('/', '_', $this->flexibee->get($evidence, $id, ['detail' => ['kod']])[0]['kod']);
        } else {
            return null;
        }
    }

    /**
     * @param object $user
     * @return string|null
     */
    public function getEmailText($doklId, $evidence): ?string {
        return $this->flexibee->get($evidence, $doklId, [
                    'includes' => "/$evidence/typDokl/",
                    'detail' => ['typDokl(emailTxt)']
                ])[0]['typDokl'][0]['emailTxt'] ?? null;
    }

    /**
     * @param object $user
     * @return string|null
     */
    public function getEmailSign(object $user): ?array {
        $userId = $user->getIdentity()->getData()['kontakt']['id'];
        $kontakt = $this->flexibee->get('kontakt', $userId, [
            'relations' => 'prilohy',
            'detail' => ['prilohy(nazSoub,content)']
        ]);
        foreach ($kontakt[0]['prilohy'] as $priloha) {
            if ($priloha['nazSoub'] == 'mail_sign.html') {
                return [
                    'id' => $priloha['id'],
                    'content' => base64_decode($priloha['content'])
                ];
            }
        }
        return null;
    }

    public function saveSign($sign, $idPrilohy) {
        return $this->flexibee->put('priloha', ['winstrom' => [
                        'priloha' => [
                            'id' => $idPrilohy,
                            'content' => base64_encode($sign),
                            'content@encoding' => 'base64'
                        ]
        ]]);
    }

    public function createSign($sign, $idKontaktu) {
        return $this->flexibee->put('kontakt', ['winstrom' => [
                        'kontakt' => [
                            'id' => $idKontaktu,
                            'prilohy' => [
                                'priloha' => [
                                    'nazSoub' => 'mail_sign.html',
                                    'contentType' => 'text/html',
                                    'content@encoding' => 'base64',
                                    'content' => base64_encode($sign)
                                ]
                            ]
        ]]]);
    }

}
