<?php
/**
 * TL_ROOT/system/modules/isotope/languages/de/tl_catalog_types.php 
 * 
 * TYPOlight extension: catalog 0.3.5 stable 
 * Deutsch translation file 
 * 
 * Copyright : &copy; 2008 s.c.a.r.e., Thyon Design 
 * License   : LGPL 
 * Author    : John Brand (thyon), http://www.thyon.com/ 
 * Translator: Joachim Scholtysik (jscholtysik) 
 * 
 * This file was created automatically be the TYPOlight extension repository translation module.
 * Do not edit this file manually. Contact the author or translator for this module to establish 
 * permanent text corrections which are update-safe. 
 */
 
$GLOBALS['TL_LANG']['tl_catalog_types']['name']['0'] = "Name";
$GLOBALS['TL_LANG']['tl_catalog_types']['name']['1'] = "Katalogname.";
$GLOBALS['TL_LANG']['tl_catalog_types']['tableName']['0'] = "Tabellenname";
$GLOBALS['TL_LANG']['tl_catalog_types']['tableName']['1'] = "Name der Datenbank-Tabelle, in die die Einträge gespeichert werden.";
$GLOBALS['TL_LANG']['tl_catalog_types']['noTable']['0'] = "Unabhängige Tabelle";
$GLOBALS['TL_LANG']['tl_catalog_types']['noTable']['1'] = "Falls angehakt, wird die Tabelle nicht aktualisiert, wenn Katalogfelder hinzugefügt oder gelöscht werden. Nützlich, um bestehende Tabelle zu bearbeiten.";
$GLOBALS['TL_LANG']['tl_catalog_types']['addImage']['0'] = "Ein Bild hinzufügen";
$GLOBALS['TL_LANG']['tl_catalog_types']['addImage']['1'] = "Wenn Sie diese Option wählen, wird ein Bild zur Auflistung der Katalogtypen hinzugefügt.";
$GLOBALS['TL_LANG']['tl_catalog_types']['singleSRC']['0'] = "Bilddatei";
$GLOBALS['TL_LANG']['tl_catalog_types']['singleSRC']['1'] = "Bitte wählen Sie das Bild aus, das in der Auflistung der Katalogtypen angezeigt werden soll.";
$GLOBALS['TL_LANG']['tl_catalog_types']['size']['0'] = "Bildbreite und -höhe";
$GLOBALS['TL_LANG']['tl_catalog_types']['size']['1'] = "Bitte geben Sie entweder die Bildbreite, die Bildhöhe oder beide Maße ein, um die Bildgröße zu ändern. Wenn Sie beide Felder leer lassen, wird die Original-Bildgröße angezeigt.";
$GLOBALS['TL_LANG']['tl_catalog_types']['format']['0'] = "Zeichenkette des Titels formatieren";
$GLOBALS['TL_LANG']['tl_catalog_types']['format']['1'] = "Geben Sie die Format-Zeichenkette für jeden Katalog-Eintrag ein (optional). Bilder unterstützen Größenänderungen und Checkbox-Bilder werden angezeigt, falls der Wert TRUE ist..<br /><strong>Beispiel:</strong> <br /><em>&lt;strong&gt;{‎{title_field}}&lt;/strong&gt; &lt;em&gt;({‎{alias_field}})&lt;/em&gt; {‎{checkbox_field::src=imagefile.gif}} {‎{checkbox_field}}&lt;br /&gt;<br />{‎{image_field::w=100&h=80}}</em>";
$GLOBALS['TL_LANG']['tl_catalog_types']['new']['0'] = "Neuer Katalog";
$GLOBALS['TL_LANG']['tl_catalog_types']['new']['1'] = "Neuen Katalog erstellen.";
$GLOBALS['TL_LANG']['tl_catalog_types']['edit']['0'] = "Einträge verwalten";
$GLOBALS['TL_LANG']['tl_catalog_types']['edit']['1'] = "Einträge des Katalogs ID %s verwalten";
$GLOBALS['TL_LANG']['tl_catalog_types']['copy']['0'] = "Katalog-Definition kopieren";
$GLOBALS['TL_LANG']['tl_catalog_types']['copy']['1'] = "Die Katalog-Definition des Katalogs ID %s kopieren";
$GLOBALS['TL_LANG']['tl_catalog_types']['delete']['0'] = "Katalog löschen";
$GLOBALS['TL_LANG']['tl_catalog_types']['delete']['1'] = "Katalog ID %s löschen";
$GLOBALS['TL_LANG']['tl_catalog_types']['show']['0'] = "Katalog-Eigenschaften";
$GLOBALS['TL_LANG']['tl_catalog_types']['show']['1'] = "Eigenschaften von Katalog ID %s anzeigen";
$GLOBALS['TL_LANG']['tl_catalog_types']['editheader']['0'] = "Katalog bearbeiten";
$GLOBALS['TL_LANG']['tl_catalog_types']['editheader']['1'] = "Katalog bearbeiten";
$GLOBALS['TL_LANG']['tl_catalog_types']['fields']['0'] = "Felder definieren";
$GLOBALS['TL_LANG']['tl_catalog_types']['fields']['1'] = "Felder für Katalog ID %s definieren";
$GLOBALS['TL_LANG']['tl_catalog_types']['regenerateDca']['0'] = "DCA erneuern";
$GLOBALS['TL_LANG']['tl_catalog_types']['regenerateDca']['1'] = "DCA für alle Kataloge erneuern";
$GLOBALS['TL_LANG']['tl_catalog_types']['itemFormat'] = "<span style=\"color:#b3b3b3;\"><em>(%s %s)</em></span>";
$GLOBALS['TL_LANG']['tl_catalog_types']['itemSingle'] = "Eintrag";
$GLOBALS['TL_LANG']['tl_catalog_types']['itemPlural'] = "Einträge";
$GLOBALS['TL_LANG']['tl_catalog_types']['regenerateDcaExplanation'] = "TYPOlights Data Container Array (DCA) sagt TYPOlight, wie Backend-Formulare gerendert werden sollen. Um einen Weg zu schaffen, Ihre Katalogeinträge bequem zu bearbeiten, erstellt das Katalog-Modul das DCA automatisch.\nDabei kann es aber vorkommen, dass DCA und Ihr Katalog nicht mehr übereinstimmen, z.B. nachdem Sie eine neue Katalogversion installiert haben. In diesem Fall vewenden Sie bitte den Katalog erneuern Schaltknopf unten, um Ihre Kataloge mit TYPOlight zu synchronisieren.";
$GLOBALS['TL_LANG']['tl_catalog_types']['regenerateDcaSuccess'] = "TYPOlights Data Container Array wurde erfolgreich erneuert.";
 
?>
