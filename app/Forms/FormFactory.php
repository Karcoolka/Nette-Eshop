<?php

declare(strict_types=1);

namespace App\Forms;

use App\Presenters\BasePresenter;
use Nette;
use Nette\Application\UI\Form;

final class FormFactory
{
    use Nette\SmartObject;

    public function create(): Form
    {
        $form = new Form;
        $form->onError[] = [$this, 'formError'];
        return $form;
    }

    public function formError(Form $form)
    {
        $presenter = $form->getPresenterIfExists();
        if ($presenter) foreach ($form->getErrors() as $error)
            $presenter->flashMessage($error, BasePresenter::MSG_ERROR);
    }
}