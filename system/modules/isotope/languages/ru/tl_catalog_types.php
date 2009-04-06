<?php
/**
 * TL_ROOT/system/modules/isotope/languages/ru/tl_catalog_types.php 
 * 
 * TYPOlight extension: catalog 0.3.5 stable 
 * Russian translation file 
 * 
 * Copyright : &copy; 2008 s.c.a.r.e., Thyon Design 
 * License   : LGPL 
 * Author    : John Brand (thyon), http://www.thyon.com/ 
 * Translator: Dmitry Kuznetsov (kuzmich), http://on.freedom-vrn.ru 
 * 
 * This file was created automatically be the TYPOlight extension repository translation module.
 * Do not edit this file manually. Contact the author or translator for this module to establish 
 * permanent text corrections which are update-safe. 
 */
 
$GLOBALS['TL_LANG']['tl_catalog_types']['name']['0'] = "Имя";
$GLOBALS['TL_LANG']['tl_catalog_types']['name']['1'] = "Имя каталога";
$GLOBALS['TL_LANG']['tl_catalog_types']['tableName']['0'] = "Имя таблицы";
$GLOBALS['TL_LANG']['tl_catalog_types']['tableName']['1'] = "Название таблицы базы данных, для сохранения элементов.";
$GLOBALS['TL_LANG']['tl_catalog_types']['noTable']['0'] = "Независимая таблица";
$GLOBALS['TL_LANG']['tl_catalog_types']['noTable']['1'] = "Если выбрано, таблица базы данных не будет обновлена при добавлении или удалении полей каталога. Полезно для редактирования уже существующих таблиц.";
$GLOBALS['TL_LANG']['tl_catalog_types']['addImage']['0'] = "Добавить изображение";
$GLOBALS['TL_LANG']['tl_catalog_types']['addImage']['1'] = "Если выбрать опцию, изображение будет добавлено к списку каталога.";
$GLOBALS['TL_LANG']['tl_catalog_types']['singleSRC']['0'] = "Изображение";
$GLOBALS['TL_LANG']['tl_catalog_types']['singleSRC']['1'] = "Пожалуйста, выберите изображение, которое будет показано в списке каталога.";
$GLOBALS['TL_LANG']['tl_catalog_types']['size']['0'] = "Ширина и высота изображения";
$GLOBALS['TL_LANG']['tl_catalog_types']['size']['1'] = "Пожалуйста, введите либо ширину, либо высоту изображения, либо оба значения, для изменения размера изображения. Если оставить оба поля пустыми, изображение будет показано в оригинальном размере.";
$GLOBALS['TL_LANG']['tl_catalog_types']['format']['0'] = "Формат названия строк";
$GLOBALS['TL_LANG']['tl_catalog_types']['format']['1'] = "Введите строку формата для каждого элемента каталога (опционально). Если включено, изображения поддерживают изменение размера и чек-боксы. <br /><strong>Пример:</strong> <br /><em>&lt;strong&gt;{‎{title_field}}&lt;/strong&gt; &lt;em&gt;({‎{alias_field}})&lt;/em&gt; {‎{checkbox_field::src=imagefile.gif}} {‎{checkbox_field}}&lt;br /&gt;<br />";
$GLOBALS['TL_LANG']['tl_catalog_types']['new']['0'] = "Новый каталог";
$GLOBALS['TL_LANG']['tl_catalog_types']['new']['1'] = "Создать новый каталог.";
$GLOBALS['TL_LANG']['tl_catalog_types']['edit']['0'] = "Управление элементами";
$GLOBALS['TL_LANG']['tl_catalog_types']['edit']['1'] = "Управление элементами каталога ID %s";
$GLOBALS['TL_LANG']['tl_catalog_types']['copy']['0'] = "Копировать определение каталога";
$GLOBALS['TL_LANG']['tl_catalog_types']['copy']['1'] = "Копировать определение каталога ID %s";
$GLOBALS['TL_LANG']['tl_catalog_types']['delete']['0'] = "Удалить каталог";
$GLOBALS['TL_LANG']['tl_catalog_types']['delete']['1'] = "Удалить каталог ID %s";
$GLOBALS['TL_LANG']['tl_catalog_types']['show']['0'] = "Детали каталога";
$GLOBALS['TL_LANG']['tl_catalog_types']['show']['1'] = "Показать детали каталога ID %s";
$GLOBALS['TL_LANG']['tl_catalog_types']['editheader']['0'] = "Редактировать каталог";
$GLOBALS['TL_LANG']['tl_catalog_types']['editheader']['1'] = "Редактировать каталог";
$GLOBALS['TL_LANG']['tl_catalog_types']['fields']['0'] = "Определить поля";
$GLOBALS['TL_LANG']['tl_catalog_types']['fields']['1'] = "Определить поля для каталога ID %s";
$GLOBALS['TL_LANG']['tl_catalog_types']['regenerateDca']['0'] = "Восстановление DCA";
$GLOBALS['TL_LANG']['tl_catalog_types']['regenerateDca']['1'] = "Восстановление DCA для всех каталогов";
$GLOBALS['TL_LANG']['tl_catalog_types']['itemFormat'] = "<span style=\"color:#b3b3b3;\"><em>(%s %s)</em></span>";
$GLOBALS['TL_LANG']['tl_catalog_types']['itemSingle'] = "элемент";
$GLOBALS['TL_LANG']['tl_catalog_types']['itemPlural'] = "элементы";
$GLOBALS['TL_LANG']['tl_catalog_types']['regenerateDcaExplanation'] = "Массив данных контейнера (DCA) определяет метод отображаения форм и передает его TYPOlight. Для обеспечения удобного способа редактирования элементов каталога, модуль создает DCA для вас автоматически. Однако, иногда DCA и ваш каталог могут выйти из синхронизации, например после того, как вы устанавливаете новую версию \"Каталога\", в этом случае используйте кнопку восстановления DCA, для синхронизации ваших каталогов с TYPOlight.";
$GLOBALS['TL_LANG']['tl_catalog_types']['regenerateDcaSuccess'] = "Массив данных контейнера был успешно восстановлен.";
 
?>
