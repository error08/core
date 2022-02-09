<?php

namespace App\EventListener\DataContainer;

use Contao\CoreBundle\ServiceAnnotation\Callback;
use Contao\DataContainer;
use Isotope\Model\Document;
use Isotope\Model\ProductCollection\Order;

/**
 * @Callback(table="tl_iso_product_collection", target="select.buttons")
 */
class SelectButtonsCallbackListener
{
    public function __invoke(array $arrButtons, DataContainer $dc)
    {
        $strRedirectUrl = str_replace('&key=print_documents2', '', \Environment::get('request'));
        if(\Input::get('act') == 'select' && 'tl_select' === \Input::post('FORM_SUBMIT')) {

            \System::log('POST: '.print_r($_POST,1), __METHOD__, TL_GENERAL);
            \System::log('GET: '.print_r($_GET,1), __METHOD__, TL_GENERAL);
            \System::log('DC: '.print_r($dc->idÓ,1), __METHOD__, TL_GENERAL);
            $orders = Order::findMultipleByIds($_POST['IDS']);
            if (count($orders) == 0) {
                \Message::addError('Could not find orders for ids.');
                \Controller::redirect($strRedirectUrl);
            }

            /** @var \Isotope\Interfaces\IsotopeDocument $objDocument */
            if (($objDocument = Document::findByPk(\Input::post('documentId'))) === null) {
                \Message::addError('Could not find document id.');
                \Controller::redirect($strRedirectUrl);
            }
            // Set the language of the logged in user
            \System::loadLanguageFile('default', System::getContainer()->get('request_stack')->getCurrentRequest()->getLocale(), true);

            $arrCollection = array();
            $i = 0;
            foreach ($orders as $order) {
                $arrCollection[$i] = $order;
                $i++;
            }
            $objDocument->outputDocumentsToBrowser($arrCollection);
            return $arrButtons;
        } else {
            unset($arrButtons['copy']);
            unset($arrButtons['cut']);
            $documents = Document::findAll();
            foreach ($documents as $document) {
                array_push($arrButtons, '<input type="hidden" name="documentId" value="' . $document->id . '"/><button type="submit" name="printDocuments" value="1" class="tl_submit">' . $document->name . ' drucken</>');
            }

            return $arrButtons;
        }
    }
}
