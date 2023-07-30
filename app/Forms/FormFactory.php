<?php
declare(strict_types=1);

namespace App\Forms;

use App\Presenters\BasePresenter;
use Nette;
use Nette\Application\UI\Form;

/**
 * Továrna na vytváření formulářů.
 * @package App\Forms
 */
final class FormFactory
{
	use Nette\SmartObject;

	/**
	 * Vytváří a vrací nový formulář se společným výchozím nastavením.
	 * @return Form nový formulář se společným výchozím nastavením
	 */
	public function create(): Form
	{
		$form = new Form;
		// Prostor pro výchozí nastavení.
		$form->onError[] = [$this, 'formError'];
		return $form;
	}

	/**
	 * Převádí výpis chyb validace formuláře na zprávy ve stránce.
	 * @param Form $form formulář ze kterého chyby pochází
	 */
	public function formError(Form $form)
	{
		$presenter = $form->getPresenterIfExists();
		if ($presenter) foreach ($form->getErrors() as $error)
			$presenter->flashMessage($error, BasePresenter::MSG_ERROR);
	}
}