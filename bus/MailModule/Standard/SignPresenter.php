<?php

namespace Bus\MailModule\Presenters\Standard;

use \Nette\Application\UI;

/**
 * Description of MailPresenter
 *
 * @author viky
 */
class SignPresenter extends \Bus\Presenters\Override\SecuredPresenter {

    /**
     * @inject
     * @var \Bus\MailModule\Models\Override\MailModel
     */
    public $model;
    protected $sign = null;
    protected $signId = null;

    public function actionDefault(?int $id, ?string $evidence, ?string $firma) {
        $this->sign = $this->model->getEmailSign($this->getUser())['content'] ?? "";
        $this->signId = $this->model->getEmailSign($this->getUser())['id'] ?? "";
    }

    public function renderDefault() {

    }

    protected function createComponentSignForm() {
        $form = new \Bus\Utils\BootstrapForm();
        $form->getElementPrototype()->onsubmit('tinyMCE.triggerSave()');
        $form->addTextArea('body', 'Text: ')
                ->setHtmlAttribute('class', 'mceEditor')->setDefaultValue($this->sign);
        $form->addSubmit('save', 'Uložit')->setHtmlAttribute('class', 'btn btn-primary btn-lg');
        $form->onSuccess[] = [$this, 'signFormSubmitted'];

        return $form;
    }

    public function signFormSubmitted(\Nette\Application\UI\Form $form, \Nette\Utils\ArrayHash $values) {
        if ($this->signId) {
            $res = $this->model->saveSign($values['body'], $this->signId);
        } else {
            $res = $this->model->createSign($values['body'], $this->user->getIdentity()->getData()['kontakt']['id']);
        }
        if ($res['success'] == 'true') {
            $this->flashMessage("Uložení proběhlo v pořádku.", 'alert-success');
            $this->redirect('this');
        } else {
            $this->flashMessage('Nepodařilo se uložit podpis.', 'alert-danger');
        }
    }

}
