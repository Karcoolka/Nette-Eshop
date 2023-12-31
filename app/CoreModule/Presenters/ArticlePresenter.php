<?php

declare(strict_types=1);

namespace App\CoreModule\Presenters;

use App\CoreModule\Model\ArticleManager;
use App\Presenters\BasePresenter;
use Nette\Application\AbortException;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Form;
use Nette\Database\UniqueConstraintViolationException;
use Nette\Utils\ArrayHash;

/**
 * Presenter pro vykreslování článků.
 * @package App\CoreModule\Presenters
 */
class ArticlePresenter extends BasePresenter
{
    /** @var string URL výchozího článku. */
    private string $defaultArticleUrl;

    /** @var ArticleManager Model pro správu s článků. */
    private ArticleManager $articleManager;

    /**
     * Konstruktor s nastavením URL výchozího článku a injektovaným modelem pro správu článků.
     * @param string         $defaultArticleUrl URL výchozího článku
     * @param ArticleManager $articleManager    automaticky injektovaný model pro správu článků
     */
    public function __construct(string $defaultArticleUrl, ArticleManager $articleManager)
    {
        parent::__construct();
        $this->defaultArticleUrl = $defaultArticleUrl;
        $this->articleManager = $articleManager;
    }

    /** Načte a předá seznam článků do šablony. */
    public function renderList()
    {
        $this->template->articles = $this->articleManager->getArticles();
    }

    /**
     * Načte a vykreslí úvodní článek do šablony.
     * @param string|null $url URL článku
     * @throws BadRequestException Jestliže uvodni článek nebyl nalezen.
     */
    public function renderDefault(string $url = null)
    {
        // Pokud není zadaná URL, vykreslí se výchozí článek.
        if (!$url)
            $url = $this->defaultArticleUrl;

        // Pokusí se načíst článek s danou URL a pokud nebude nalezen, vyhodí chybu 404.
        if (!($article = $this->articleManager->getArticle($url)))
            $this->error(); // Vyhazuje výjimku BadRequestException.


        $this->template->article = $article; // Předá článek do šablony.
    }

    /**
     * Odstraní článek.
     * @param string|null $url URL článku
     * @throws AbortException
     */
    public function actionRemove(string $url = null)
    {
        $this->articleManager->removeArticle($url);
        $this->flashMessage('Článek byl úspěšně odstraněn.', self::MSG_SUCCESS);
        $this->redirect('Article:list');
    }

    /**
     * Vykresluje formulář pro editaci článku podle zadané URL.
     * Pokud URL není zadána, nebo článek s danou URL neexistuje, vytvoří se nový.
     * @param string|null $url URL adresa článku
     */
    public function actionEditor(string $url = null)
    {
        if ($url) {
            if (!($article = $this->articleManager->getArticle($url)))
                $this->flashMessage('Článek nebyl nalezen.', self::MSG_ERROR); // Výpis chybové hlášky.
            else $this['editorForm']->setDefaults($article); // Předání hodnot článku do editačního formuláře.
        }
    }

    /**
     * Vytváří a vrací formulář pro editaci článků.
     * @return Form formulář pro editaci článků
     */
    protected function createComponentEditorForm()
    {
        // Vytvoření formuláře a definice jeho polí.
        $form = $this->formFactory->create();
        $form->addHidden('article_id');
        $form->addText('title', 'Titulek')->setRequired();
        $form->addText('url', 'URL')->setRequired();
        $form->addText('description', 'Popisek')->setRequired();
        $form->addTextArea('content', 'Obsah');
        $form->addSubmit('save', 'Uložit článek');

        // Funkce se vykonaná při úspěšném odeslání formuláře a zpracuje zadané hodnoty.
        $form->onSuccess[] = function (Form $form, ArrayHash $values) {
            try {
                $this->articleManager->saveArticle($values);
                $this->flashMessage('Článek byl úspěšně uložen.', self::MSG_SUCCESS);
                $this->redirect('Article:default', $values->url);
            } catch (UniqueConstraintViolationException $e) {
                $this->flashMessage('Článek s touto URL adresou již existuje.', self::MSG_ERROR);
            }
        };

        return $form;
    }
}
