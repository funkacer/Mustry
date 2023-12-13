<?php

namespace Bus\UsersModule\Models\Standard;

use \Arit\Http\Promise\IPromiseArrayWrapper;

/**
 * Description of PrehledModel
 *
 * @author viky
 */
class UsersModel {

    use \Nette\SmartObject;

    /**
     * @var \Arit\Flexibee\Model\ObjFlexibee
     */
    protected $flexibee;

    /**
     * soubor pro roli shop
     * @var string
     */
    protected $shopRolesFile;

    /**
     * soubor roli pro bus
     * @var string
     */
    protected $busRolesFile;

    /**
     * soubor roli pro shop
     * @var string
     */
    protected $posRolesFile;

    /**
     * soubor profilu pro bus
     * @var string
     */
    protected $busProfileFile;

    /**
     * @var \Bus\Models\Override\Core
     */
    protected $core;

    /**
     *
     * @var array
     */
    protected $imapConfig;

    function __construct(\Arit\Flexibee\Model\ObjFlexibee $flexibee, array $config, \Bus\Models\Override\Core $core, array $imapConfig) {
        $this->flexibee = $flexibee;
        $this->shopRolesFile = $config['shopRolesFile'];
        $this->busRolesFile = $config['busRolesFile'];
        $this->busProfileFile = $config['busProfileFile'];
        $this->core = $core;
        $this->imapConfig = $imapConfig;
    }

    public function getList(?string $sort = 'id@a', array $filter = [], $start = 0, $limit = 16, $detail): IPromiseArrayWrapper {
        return $this->flexibee->get('kontakt', $filter, [
                    'order' => $sort,
                    'limit' => $limit,
                    'start' => $start,
                    'detail' => $detail,
                    'add-row-count' => 'true',
                    'includes' => '/kontakt/firma/',
        ]);
    }

    public function getOne(int $id, $detail = 'full'): ?array {
        $user = $this->flexibee->get('kontakt', $id, [
                    'detail' => $detail,
                    'relations' => 'prilohy'
                ])[0] ?? [];
        foreach ($user['prilohy'] as $priloha) {
            if (isset($priloha['nazSoub']) && $priloha['nazSoub'] == $this->shopRolesFile) {
                $user['shopPrilohaId'] = $priloha['id'];
                $user['shopRoles'] = json_decode(base64_decode($priloha['content']), true)['role'] ?? [];
            }
            if (isset($priloha['nazSoub']) && $priloha['nazSoub'] == $this->busRolesFile) {
                $user['busPrilohaId'] = $priloha['id'];
                $user['busRoles'] = json_decode(base64_decode($priloha['content']), true)['role'] ?? [];
            }
            if (isset($priloha['nazSoub']) && $priloha['nazSoub'] == $this->busProfileFile) {
                $user['busProfileId'] = $priloha['id'];
                $user = array_merge($user, json_decode(base64_decode($priloha['content']), true)['profile'] ?? []);
            }
        }
        return $user;
    }

    public function decryptImapPassword($imapPassword) {
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
        return openssl_decrypt ($imapPassword, $ciphering, $decryption_key, $options, $decryption_iv);
    }

    public function encryptImapPassword($imapPassword) {
        // Store the cipher method
        $ciphering = $this->imapConfig['ciphering'];
        // Use OpenSSl Encryption method
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        // Non-NULL Initialization Vector for encryption
        $encryption_iv = $this->imapConfig['vector'];
        // Store the encryption key
        $encryption_key = $this->imapConfig['key'];
        // Use openssl_encrypt() function to encrypt the data
        return openssl_encrypt($imapPassword, $ciphering, $encryption_key, $options, $encryption_iv);
    }

    public function saveKontakt(array $user): ?array {
        $res = $this->flexibee->put('kontakt', [
                    'winstrom' => [
                        'kontakt' => [$user]
                    ]
                        ]
                )->toArray();
        if($res['success'] === 'true') {
            if (isset($user['busRoles'])) {
                if (isset($user['busPrilohaId']) && $user['busPrilohaId'] > 0) {
                    $this->savePriloha($user['busPrilohaId'], ['role' => $user['busRoles']]);
                } else {
                    $this->newPriloha($res['results'][0]['id'], ['role' => $user['busRoles']], $this->busRolesFile);
                }
            }

            if (isset($user['shopRoles'])) {
                if (isset($user['shopPrilohaId']) && $user['shopPrilohaId'] > 0) {
                    $this->savePriloha($user['shopPrilohaId'], ['role' => $user['shopRoles']]);
                } else {
                    $this->newPriloha($res['results'][0]['id'], ['role' => $user['shopRoles']], $this->shopRolesFile);
                }
            }

            if (isset($user['imapname']) && isset($user['imappass']) && isset($user['imapserv'])
                && isset($user['imapport']) && isset($user['imapsifr']) && isset($user['imapfold'])) {
                    if (isset($user['busProfileId']) && $user['busProfileId'] > 0) {
                        $this->savePriloha($user['busProfileId'], ['profile' => ['imapname' => $user['imapname'], 'imappass' => $user['imappass']
                        , 'imapserv' => $user['imapserv'], 'imapport' => $user['imapport'], 'imapsifr' => $user['imapsifr'], 'imapfold' => $user['imapfold']]]);
                    } else {
                        $this->newPriloha($res['results'][0]['id'], ['profile' => ['imapname' => $user['imapname'], 'imappass' => $user['imappass']
                        , 'imapserv' => $user['imapserv'], 'imapport' => $user['imapport'], 'imapsifr' => $user['imapsifr'], 'imapfold' => $user['imapfold']]], $this->busProfileFile);
                    }
            }
        }
        return $res;
    }

    public function newPriloha(int $kontaktId, array $content, string $filename) {
        return $this->flexibee->put('kontakt', [
                    'winstrom' => [
                        'kontakt' => [
                            'id' => $kontaktId,
                            'prilohy' => [
                                'priloha' => [
                                    'nazSoub' => $filename,
                                    'contentType' => 'application/json',
                                    'content@encoding' => 'base64',
                                    'content' => base64_encode(json_encode($content)),
                                ],
                            ],
                        ],
                    ],
                ])->toArray();
    }

    public function savePriloha(int $id, array $content): ?array {
        return $this->flexibee->put('priloha', [
                    'winstrom' => [
                        'priloha' => [
                            'id' => $id,
                            'content@encoding' => 'base64',
                            'content' => base64_encode(json_encode($content)),
                        ],
                    ]
                ])->toArray();
    }

    public function saveHeslo(int $userId, string $username, string $password): array {
        $query = '<winstrom>'
                . '<kontakt>'
                . '<username>' . $username . '</username>'
                . '<password>' . $password . '</password>'
                . '</kontakt>'
                . '</winstrom>';
        $res = $this->flexibee->putRaw('kontakt/' . $userId . '.xml', $query);
        if (strpos($res, '<success>true') !== FALSE) {
            return ['success' => true];
        } else {
            return [
                'success' => false,
                'message' => $res,
            ];
        }
    }

    /**
     * @param string $stitek
     * @param string $kontaktId
     * @return array
     */
    public function addKontaktStitek(string $stitek, string $kontaktId): array {
        $data = $this->flexibee->put('kontakt', [
            'winstrom' => [
                'kontakt' => [
                    'id' => $kontaktId,
                    'stitky' => $stitek,
                ],
            ]
        ]);
        return $data->toArray();
    }

    /**
     * pozor, přepíše všechny štítky
     * @param array $stitky
     * @param int $idKontakt
     * @return array
     */
    public function setKontaktStitek(array $stitky, int $idKontakt): array {
        $data = $this->flexibee->put('kontakt', [
            'winstrom' => [
                'kontakt' => [
                    'id' => $idKontakt,
                    "stitky@removeAll" => "true",
                    "stitky" => implode(',', $stitky),
                ],
            ]
        ]);
        return $data->toArray();
    }

    public function removeStitek(int $id, string $stitek) {
        $stitky = $this->flexibee->get('kontakt', [
                    'id' => $id], [
                    'detail' => ['id', 'kod', 'stitky'],
                    'limit' => 0,
                ])->toArray();
        $stitkyNove = [];
        if (count($stitky) > 0) {
            $stitky = explode(',', $stitky[0]['stitky']);
            if (count($stitky) > 0) {
                foreach ($stitky as $value) {
                    if (trim($value) !== $stitek) {
                        $stitkyNove[count($stitkyNove)] = $value;
                    }
                }
            }
        }
        $data = $this->flexibee->put('kontakt', [
            'winstrom' => [
                'kontakt' => [
                    'id' => $id,
                    'stitky@removeAll' => 'true',
                    'stitky' => implode(',', $stitkyNove)
                ],
            ]
        ]);
        return $data->toArray();
    }

}
