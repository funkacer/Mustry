<?php

declare(strict_types=1);

namespace App\Presenters;

use Nette;
use Nette\Application\UI\Form;
use Nette\Forms\Form as FormsForm;

final class ZmenaUctuPresenter extends BasePresenter {

    /**
     * @inject
     * @var \App\Models\ZmenaUctuModel
     */
    public $model;

    /**
     * @var array
     */
    public $config;

    /**
     * @var ?array
     */
    protected $stavy = ['' => 'Vyberte:',
    'prep' => 'V přípravě',
    'default' => 'Normální',
    'banned' => 'Zakázaný'];

    /**
     * @var ?int
     */
    public $id;

    /**
     * @var ?string
     */
    public $od;

    /**
     * @var ?string
     */
    public $do;

    /**
     * Vrací progress spuštěné úlohy
     */

    function __construct() {
        $this->config = \Nette\Neon\Neon::decode(file_get_contents('../app/config/common.neon'))['parameters']['config'];
    }

    public function renderDefault()
    {
        bdump($this->user->isLoggedIn());
        bdump($this->getUser()->isLoggedIn());
        bdump($_SESSION['fb-company']);
    }

    protected function createComponentSelectForm(): \Nette\ComponentModel\Component {

        $datas = $this->model->getAllData("ucet");
        bdump($datas);
        $ucty = [];

        if (isset($this->id)) {
            bdump($this->id, "ID IS SET!!!!");
            bdump($this->od, "OD IS SET!!!!");
            bdump($this->do, "DO IS SET!!!!");

            foreach($datas as $data) {
                if($data['id'] == $this->id) {
                    $ucty[$data['id']] = $data['kod'].": ".$data['nazev'];
                }
            }

            $row['ucet'] = $this->id;
            $row['DatumOD'] = $this->od;
            $row['DatumDO'] = $this->do;

            $form = new \Nette\Application\UI\Form;
            
            $form->addText('DatumOD', "Datum od")
                ->setHtmlType('date')
                ->setRequired("Vyplňte prosím Datum od")
                ->setHtmlAttribute("class", "form-control")
                ->setHtmlAttribute("placeholder", "Datum od");
            $form->addText('DatumDO', "Datum do")
                ->setHtmlType('date')
                ->setRequired("Vyplňte prosím Datum do")
                ->setHtmlAttribute("class", "form-control")
                ->setHtmlAttribute("placeholder", "Datum do");
            //$form->addText('stav', "Stav")
            $form->addSelect('ucet', 'Úcet', $ucty)
                ->setRequired("Vyberte prosím účet")
                ->setHtmlAttribute("class", "form-control")
                ->setHtmlAttribute("placeholder", "Stav");

            $form->setDefaults($row);

            $form->addSubmit('submit', 'Potvrdit výběr')
                //->setHtmlAttribute('class', 'btn btn-success');
                ->setHtmlAttribute('class', 'btn btn-primary')
                ->setDisabled();
                //->setHtmlAttribute('onclick', 'zprava()');
                //->setHtmlAttribute('class', 'ajax');

        } else {
            foreach($datas as $data) {
                $ucty[$data['id']] = $data['kod'].": ".$data['nazev'];
            }

            $form = new \Nette\Application\UI\Form;
            
            $form->addText('DatumOD', "Datum od")
                ->setHtmlType('date')
                ->setRequired("Vyplňte prosím Datum od")
                ->setHtmlAttribute("class", "form-control")
                ->setHtmlAttribute("placeholder", "Datum od");
            $form->addText('DatumDO', "Datum do")
                ->setHtmlType('date')
                ->setRequired("Vyplňte prosím Datum do")
                ->setHtmlAttribute("class", "form-control")
                ->setHtmlAttribute("placeholder", "Datum do");
            //$form->addText('stav', "Stav")
            $form->addSelect('ucet', 'Úcet', $ucty)
                ->setRequired("Vyberte prosím účet")
                ->setHtmlAttribute("class", "form-control")
                ->setHtmlAttribute("placeholder", "Stav");

            //$form->setDefaults($row);

            $form->addSubmit('submit', 'Potvrdit výběr')
                //->setHtmlAttribute('class', 'btn btn-success');
                ->setHtmlAttribute('class', 'btn btn-primary');
                //->setHtmlAttribute('onclick', 'zprava()');
                //->setHtmlAttribute('class', 'ajax');
            /*
            $form->addButton('cancel', 'Zrušit')
                ->setHtmlAttribute('class', 'btn btn-outline-danger')
                ->setHtmlAttribute('onclick', 'window.location="' . $this->link('Zmenauctu:') . '";');
            */

            $form->onSuccess[] = [$this, 'selectFormSubmitted'];
        }
        
        return $form;
    }

    public function selectFormSubmitted(\Nette\Application\UI\Form $form, \Nette\Utils\ArrayHash $values) {
        bdump($values);

        $this->redirect("ZmenaUctu:result", ['id' => $values['ucet']."_".$values['DatumOD']."_".$values['DatumDO']]);
        
    }

    public function actionResult($id)
    {
        bdump($id);

        $this->id = explode('_', $id)[0];
        $this->od = explode('_', $id)[1];
        $this->do = explode('_', $id)[2];

        $datas = $this->model->getAllData("ucet");
        foreach($datas as $data) {
            if($data['id'] == $this->id){
                $kod = $data['kod'];
                bdump($kod);
            }
        }
        $ucty = [];
        foreach($datas as $data) {
            if (substr($data['kod'],0,3) == substr($kod,0,3) && $data['kod'] != $kod) {
                $ucty[$data['id']] = $data['kod'].": ".$data['nazev'];
            }
        }

        bdump($ucty);
    }


    protected function createComponentResultForm(): \Nette\ComponentModel\Component {

        $datas = $this->model->getAllData("ucet");
        bdump($datas);
        $ucty = [];
        foreach($datas as $data) {
            $ucty[$data['id']] = $data['kod'].": ".$data['nazev'];
        }

        $form = new \Nette\Application\UI\Form;
        
        $form->addText('DatumOD', "Datum od")
            ->setHtmlType('date')
            ->setRequired("Vyplňte prosím Datum od")
            ->setHtmlAttribute("class", "form-control")
            ->setHtmlAttribute("placeholder", "Datum od");
        $form->addText('DatumDO', "Datum do")
            ->setHtmlType('date')
            ->setRequired("Vyplňte prosím Datum do")
            ->setHtmlAttribute("class", "form-control")
            ->setHtmlAttribute("placeholder", "Datum do");
        //$form->addText('stav', "Stav")
        $form->addSelect('ucet', 'Úcet', $ucty)
            ->setRequired("Vyberte prosím účet")
            ->setHtmlAttribute("class", "form-control")
            ->setHtmlAttribute("placeholder", "Stav");

        //$form->setDefaults($row);

        $form->addSubmit('submit', 'Potvrdit výběr')
            //->setHtmlAttribute('class', 'btn btn-success');
            ->setHtmlAttribute('class', 'btn btn-primary');
            //->setHtmlAttribute('onclick', 'zprava()');
            //->setHtmlAttribute('class', 'ajax');
        /*
        $form->addButton('cancel', 'Zrušit')
            ->setHtmlAttribute('class', 'btn btn-outline-danger')
            ->setHtmlAttribute('onclick', 'window.location="' . $this->link('Zmenauctu:') . '";');
        */

        $form->onSuccess[] = [$this, 'resultFormSubmitted'];
        return $form;
    }

    public function resultFormSubmitted(\Nette\Application\UI\Form $form, \Nette\Utils\ArrayHash $values) {
        bdump($values);

        $datas = $this->model->getAllData("ucet");
        foreach($datas as $data) {
            if($data['id'] == $values['ucet']){
                $kod = $data['kod'];
                bdump($kod);
            }
        }
        $ucty = [];
        foreach($datas as $data) {
            if (substr($data['kod'],0,3) == substr($kod,0,3) && $data['kod'] != $kod) {
                $ucty[$data['id']] = $data['kod'].": ".$data['nazev'];
            }
        }

        bdump($ucty);
        
    }

}
