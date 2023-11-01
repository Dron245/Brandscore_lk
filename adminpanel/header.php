<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

$assets = \Bitrix\Main\Page\Asset::getInstance();

$assets->addJs(SITE_TEMPLATE_PATH . "/assets/js/jquery-3.6.0.min.js");
$assets->addJs(SITE_TEMPLATE_PATH . "/assets/js/parallax.js");
$assets->addJs(SITE_TEMPLATE_PATH . "/assets/js/script.js");

$assets->addCss(SITE_TEMPLATE_PATH . "/assets/js/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css");
//$assets->addJs(SITE_TEMPLATE_PATH . "/assets/js/malihu-custom-scrollbar-plugin/jquery.mousewheel.min.js");
$assets->addJs(SITE_TEMPLATE_PATH . "/assets/js/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.js");

$assets->addCss(SITE_TEMPLATE_PATH . "/assets/js/OverlayScrollbars/css/OverlayScrollbars.min.css");
$assets->addCss(SITE_TEMPLATE_PATH . "/assets/js/OverlayScrollbars/css/os-theme-thin-dark.css");
$assets->addJs(SITE_TEMPLATE_PATH . "/assets/js/OverlayScrollbars/js/jquery.overlayScrollbars.min.js");

$assets->addCss(SITE_TEMPLATE_PATH . "/assets/js/select2/select2.min.css");
$assets->addJs(SITE_TEMPLATE_PATH . "/assets/js/select2/select2.full.min.js");


if(Seoven\User\Manager::isManager()){

}
$assets->addCss(SITE_TEMPLATE_PATH . "/assets/js/jquery-confirm/jquery-confirm.min.css");
$assets->addJs(SITE_TEMPLATE_PATH . "/assets/js/jquery-confirm/jquery-confirm.min.js");

$assets->addCss(SITE_TEMPLATE_PATH . "/assets/js/help/lib.css");
$assets->addCss(SITE_TEMPLATE_PATH . "/assets/css/style.css");

if($USER->IsAuthorized()){
	$client = Seoven\User\Client::getInstance();
	$client->init($USER->GetID());
	$clientData = $client->getData();
	$clientNotif = $client->getNotif();
	//pre($clientData);

    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();
    if($arUser['UF_TIPS1']==1){setcookie('help1','1',time()+360000,'/');}
    if($arUser['UF_TIPS2']==1){setcookie('help2','1',time()+360000,'/');}
    if($arUser['UF_TIPS3']==1){setcookie('help3','1',time()+360000,'/');}




}
?>
<!DOCTYPE html>
<html>
	<head>
		<title><?$APPLICATION->ShowTitle();?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
		<?$APPLICATION->ShowHead();?>
        <script src="<?echo SITE_TEMPLATE_PATH . "/assets/js/help/lib.js";?>" type="text/javascript"></script>

	</head>
	<body class="<?=$_COOKIE['theme']?><?=($APPLICATION->GetCurPage() == "/") ? " homepage" : ''?>">
		<div id="panel">
			<?$APPLICATION->ShowPanel();?>
		</div>
		<?php if($USER->IsAuthorized() && !defined("ERROR_404") && $APPLICATION->GetCurPage() != "/") { ?>
			<div class="main-wrapper <?=Seoven\User\Manager::isManager() ? "is-manager" : ""?>  <?php $APPLICATION->ShowProperty('main-class')?>">
				<div class="open-button"><svg type="i-other-arrow" width="16" fill="transparent" viewBox="0 0 8 6" xmlns="http://www.w3.org/2000/svg"><path d="M7 1L4 4L1 1" stroke="#1D1D1D" stroke-width="1.5"></path></svg></div>
				<div class="left-menu-wrapper">
	                <div class="wrapper-top-content">
	                    <div class="wrapper-logo">
	                        <a href="<?=Seoven\User\Manager::isManager() ? '/projects/' : '/projects/'?>"><?=getSVGIcon(SITE_TEMPLATE_PATH. "/assets/images/logo.svg")?><span>Brandscore</span></a>
	                    </div>
	                    <div class="wrapper-item-menu">
		                    <ul>
								<?php if($USER->IsAdmin()) { ?>
									<li class="item-menu">
										<a class="item-menu" href="/manager/add_manager/"><div class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/user-ico.svg")?></div><span>Создание менеджера</span></div></a>
									</li>
									<li class="item-menu with-arrow <?=CSite::InDir("/manager/managers/") ? "open" : ""?>">
										<div class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/user-ico.svg")?></div><span>Список менеджеров</span></div>
										<ul class="item-submenu manager-clients">
											<?php foreach(Seoven\User\Manager::getManagers() as $client) { ?>
												<li>
													<a class="item-menu" href="/manager/managers/<?=$client["ID"]?>/">
														<div class="link"><?=$client["LAST_NAME"]?> <?=$client["NAME"]?></div>
													</a>
												</li>
											<?php } ?>
										</ul>
									</li>
								<?php } ?>
			                    <?php if(Seoven\User\Manager::isManager()) {
				                    $manager = Seoven\User\Manager::getInstance();
									$managerData = $manager->getData();
			                    ?>
			                    	<?php if(!Seoven\User\Manager::isTopvisor()) { ?>
			                    	<li class="item-menu">
			                    		<div class="link"><a class="item-menu" href="/manager/add/"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/user-ico.svg")?></div><span>Создание клиента</span></a></div>
			                    	</li>

			                    	<li class="item-menu with-arrow <?=CSite::InDir("/manager/client/") ? "open" : ""?>">
			                        	<div class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/user-ico.svg")?></div><span>Список клиентов</span></div>
			                        	<ul class="item-submenu manager-clients">
				                        	<?php foreach($managerData["CLIENTS"] as $client) { ?>
				                                <li><a class="item-menu" href="/manager/client/<?=$client["ID"]?>/"><div class="link"><?=$client["NAME"]?></div></a></li>
			                                <?php } ?>
			                        	</ul>
			                    	</li>
			                    	<?php } ?>

									<?php if(!empty($managerData["REPORTS"]["GROUPS"])) { ?>
			                    	<li class="item-menu with-arrow <?=CSite::InDir("/manager/reports/") ? "open" : ""?>">
			                            <div class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/report-ico.svg")?></div><span>Отчеты</span></div>
			                            <ul class="item-submenu">
				                            <li><a class="item-menu item-menu-all" href="/manager/reports/import/"><div class="link">Импорт Мониторинг</div></a><li>
											<?php if(count($managerData["REPORTS"]["GROUPS"]) > 1) { ?>
												<li><a class="item-menu item-menu-all" href="/manager/reports/"><div class="link">Все документы</div></a><li>
				                            <?php } ?>

			                                <?php foreach($managerData["REPORTS"]["GROUPS"] as $group) { ?>
				                                <li><a class="item-menu" href="/manager<?=$group["SECTION_PAGE_URL"]?>"><div class="link"><?=$group["NAME"]?></div></a></li>
			                                <?php } ?>
		                                </ul>
			                        </li>
			                        <?php } ?>
			                        <?php if(Seoven\User\Manager::isTopvisor()) {
                                        $GLOBALS['topvisorFilter'] = ['CREATED_BY' => $USER->GetID()]; ?>
                                        <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list","menu_projects",
                                            Array(
                                                "VIEW_MODE" => "TILE",
                                                "SHOW_PARENT_NAME" => "N",
                                                "IBLOCK_TYPE" =>'content',
                                                "IBLOCK_ID" => '12',
                                                "SECTION_ID" => "",
                                                "SECTION_CODE" => "",
                                                "SECTION_URL" => "",
                                                "COUNT_ELEMENTS" => "N",
                                                "TOP_DEPTH" => "2",
                                                "SECTION_FIELDS" => "",
                                                "SECTION_USER_FIELDS" => ['UF_PROJECT', 'UF_DOMEN', 'UF_ADDRESS'],
                                                "ADD_SECTIONS_CHAIN" => "N",
                                                "CACHE_TYPE" => "N",
                                                "CACHE_TIME" => "36000000",
                                                "CACHE_NOTES" => "",
                                                "CACHE_GROUPS" => "Y",
                                                "FILTER_NAME" => "topvisorFilter"
                                            )
                                        );?>
			                        <?php } else { ?>
				                        <li class="item-menu with-arrow <?=CSite::InDir("/manager/summary/") ? "open" : ""?>">
				                        	<div class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/report-ico.svg")?></div><span>Сводка</span></div>
				                        	<ul class="item-submenu">
				                                <li><a class="item-menu" href="/manager/summary/monitoring/"><div class="link">Мониторинг</div></a></li>
				                                <li><a class="item-menu" href="/manager/summary/serm/"><div class="link">SERM</div></a></li>
			                                </ul>
				                        </li>
			                        <?php } ?>
			                        <?php if(!empty($managerData["DOCS"]["GROUPS"])) { ?>
			                    	<li class="item-menu with-arrow <?=CSite::InDir("/manager/docs/") ? "open" : ""?>">
			                            <div class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/doc-ico.svg")?></div><span>Документы</span></div>
			                            <ul class="item-submenu">
   				                            <?php if(count($managerData["DOCS"]["GROUPS"]) > 1) { ?>
												<li><a class="item-menu item-menu-all" href="/manager/docs/"><div class="link">Все документы</div></a><li>
				                            <?php } ?>

			                                <?php foreach($managerData["DOCS"]["GROUPS"] as $group) { ?>
				                                <li><a class="item-menu" href="/manager<?=$group["SECTION_PAGE_URL"]?>"><div class="link"><?=$group["NAME"]?></div></a></li>
			                                <?php } ?>
		                                </ul>
			                        </li>
			                        <?php } ?>
			                    <?php } else { ?>
			                    	<?php if($clientData["SUMMARY"]["GROUPS1"]) { ?>
				                        <li class="item-menu nopadding with-arrow <?=CSite::InDir("/summary/") ? "open" : ""?>">
				                            <div class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/analitic-ico.svg")?></div><span>Аналитика</span></div>
				                            <ul class="item-submenu">
				                                <?php foreach($clientData["SUMMARY"]["GROUPS"] as $group) { ?>
					                                <li id="<?=$group['id']?>" class="<?=CSite::InDir($group["SECTION_PAGE_URL"]) ? "active" : ""?>"><a class="item-menu" href="<?=$group["SECTION_PAGE_URL"]?>">
						                                <div class="link"><?=$group["NAME"]?></div>
						                            </a></li>
				                                <?php } ?>
			                                </ul>
				                        </li>
			                        <?php } ?>
					                <?php if($clientData["REPORTS"]["GROUPS"]) { ?>
				                        <li class="item-menu with-arrow <?=CSite::InDir("/reports/") ? "open" : ""?>">
				                            <div class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/report-ico.svg")?></div><span>Отчеты</span></div>
				                            <ul class="item-submenu">
					                            <?php if(count($clientData["REPORTS"]["GROUPS"]) > 1) { ?>
					                            	<li class="<?=CSite::InDir("/reports/") ? "active" : ""?>"><a class="item-menu item-menu-all" href="/reports/"><div class="link">Все документы</div></a></li>
					                            <?php } ?>
				                                <?php foreach($clientData["REPORTS"]["GROUPS"] as $group) { ?>
					                                <li class="<?=CSite::InDir($group["SECTION_PAGE_URL"]) ? "active" : ""?>"><a class="item-menu" href="<?=$group["SECTION_PAGE_URL"]?>"><div class="link"><?=$group["NAME"]?></div></a></li>
				                                <?php } ?>
			                                </ul>
				                        </li>
			                        <?php } ?>
			                        <?php if($clientData["DOCS"]["GROUPS"]) { ?>
				                        <li class="item-menu with-arrow <?=CSite::InDir("/docs/") ? "open" : ""?>">
				                            <div class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/doc-ico.svg")?></div><span>Документы</span></div>
				                            <ul class="item-submenu">
					                            <?php if(count($clientData["DOCS"]["GROUPS"]) > 1) { ?>
													<li class="<?=CSite::InDir("/docs/") ? "active" : ""?>"><a class="item-menu item-menu-all" href="/docs/"><div class="link">Все документы</div></a><li>
					                            <?php } ?>
				                                <?php foreach($clientData["DOCS"]["GROUPS"] as $group) { ?>
					                                <li class="<?=CSite::InDir($group["SECTION_PAGE_URL"]) ? "active" : ""?>"><a class="item-menu" href="<?=$group["SECTION_PAGE_URL"]?>"><div class="link"><?=$group["NAME"]?></div></a></li>
				                                <?php } ?>
			                                </ul>
				                        </li>
			                        <?php } ?>
			                        <?/*<li class="item-menu with-arrow">
			                        	<div class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/help-ico.svg")?></div><span>Помощь</span></div>
			                        	<ul class="item-submenu">
				                        	<li class="item-menu with-arrow">
				                        		<div class="link">Задать вопрос</div>
				                        		<ul class="item-submenu">
					                        		<li>
					                        			<div class="client-info">
										                    <?php if($clientData["PROFILE"]["MANAGER"]) { ?>
										                        <div class="avatar">
											                        <img src="<?=$clientData["PROFILE"]["MANAGER"]["UF_AVATAR"]?>" alt="avatar"/>
										                        </div>
										                        <div class="info">
										                            <div class="full-name"><?=$clientData["PROFILE"]["MANAGER"]["FULL_NAME"]?></div>
										                            <div class="status-client">Ваш аккаунт манеджер</div>
										                            <?php if($clientData["PROFILE"]["MANAGER"]["EMAIL"]) { ?>
										                    	        <a class="email" href="mailto:<?=$clientData["PROFILE"]["MANAGER"]["EMAIL"]?>"><?=$clientData["PROFILE"]["MANAGER"]["EMAIL"]?></a>
										                    	    <?php } ?>
										                            <?php if($clientData["PROFILE"]["MANAGER"]["PERSONAL_PHONE"]) { ?>
										                            	<a class="phone" href="tel:<?=$clientData["PROFILE"]["MANAGER"]["PERSONAL_PHONE"]?>"><?=$clientData["PROFILE"]["MANAGER"]["PERSONAL_PHONE"]?></a>
																	<?php } ?>

										                        </div>
										                        <button class="UIButton-white button" data-modal="manager" data-manager="<?=$clientData["PROFILE"]["MANAGER"]["ID"]?>">Связаться</button>
									                        <?php } ?>
									                    </div>
					                        		</li>
				                        		</ul>
				                        	</li>
				                        	<li><a href="/learning/" class="item-menu"><div class="link">База знаний</div></a></li>
			                        	</ul>
			                        </li>

			                        <li class="item-menu <?=CSite::InDir("/profile/") ? "active" : ""?>">
			                            <a href="/profile/" class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/user-ico.svg")?></div><span>Профиль</span></a>
			                        </li>
 */?>
			                    <?php } ?>
                                <? if(!Seoven\User\Manager::isManager()):?>


                                    <?
                                    $GLOBALS['topvisorFilter'] = ['CREATED_BY' => $USER->GetID()]; ?>
                                    <?$APPLICATION->IncludeComponent("bitrix:catalog.section.list","menu_projects",
                                        Array(
                                            "VIEW_MODE" => "TILE",
                                            "SHOW_PARENT_NAME" => "N",
                                            "IBLOCK_TYPE" =>'content',
                                            "IBLOCK_ID" => '12',
                                            "SECTION_ID" => "",
                                            "SECTION_CODE" => "",
                                            "SECTION_URL" => "",
                                            "COUNT_ELEMENTS" => "N",
                                            "TOP_DEPTH" => "2",
                                            "SECTION_FIELDS" => "",
                                            "SECTION_USER_FIELDS" => ['UF_PROJECT', 'UF_DOMEN', 'UF_ADDRESS'],
                                            "ADD_SECTIONS_CHAIN" => "N",
                                            "CACHE_TYPE" => "N",
                                            "CACHE_TIME" => "36000000",
                                            "CACHE_NOTES" => "",
                                            "CACHE_GROUPS" => "Y",
                                            "FILTER_NAME" => "topvisorFilter"
                                        )
                                    );
                                    ?>

			                    <li class="item-menu border-top-line border-bottom-line <?=CSite::InDir("/reputation/") ? "active" : ""?>">
		                            <a href="/reputation/" class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/list-ico.svg")?></div><span>Reputation pack</span></a>
		                        </li>
                                <? endif;?>
                                <li class="item-menu <?=CSite::InDir("/profile/") ? "active" : ""?>">
                                    <a href="/profile/" class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/user-icon.svg")?></div><span>Профиль</span></a>
                                </li>
                                <li class="item-menu with-arrow <?=CSite::InDir("/finance/") ? "active" : ""?>">
                                    <div class="link"><div class="link-image"><img src="<?=SITE_TEMPLATE_PATH?>/assets/images/icons/credit-card.svg"/></div><span>Финансы</span></div>
                                    <ul class="item-submenu">
                                        <li><a class="item-menu" href="/tarifs/buy/?buy_tariff=<?=$client->getTariff()['PROPERTY_NUMBERS_VALUE']?$client->getTariff()['PROPERTY_NUMBERS_VALUE']:1;?>"><div class="link">Оплата</div></a></li>
                                        <li><a class="item-menu" href="/finance/"><div class="link">Детализация платежей</div></a></li>
                                        <li><a class="item-menu" href="/tarifs/"><div class="link">Тарифы</div></a></li>
                                        <li><a class="item-menu" href="/services/additional/"><div class="link">Доп. услуги</div></a></li>
                                        <li><a class="item-menu" href="/services/"><div class="link">Подключенные услуги</div></a></li>
                                    </ul>
                                </li>
                                <li class="item-menu border-top-line <?=CSite::InDir("/learning/") ? "active" : ""?>">
                                    <a href="/learning/" class="link"><div class="link-image"><?=getSVGIcon(SITE_TEMPLATE_PATH . "/assets/images/help-ico.svg")?></div><span>Помощь</span></a>
                                </li>
                                <li class="item-menu <?=CSite::InDir("/contacts/") ? "active" : ""?>">
                                    <a href="/contacts/" class="link"><div class="link-image"></div><span>Контакты</span></a>
                                </li>
							</ul>
						</div>
	                    <div class="theme-switcher">
		                    <label class="custom-toggle">
		                    	<input type="checkbox" name="theme" <?=$_COOKIE['theme'] == "dark" ? 'checked' : ''?>>
		                    	<span class="toggle-btn"></span>
		                    	<span class="toggle-text">Dark mode</span>
		                    </label>
	                    </div>
                        <div class="tarifs-menu-block">
                            <?if(!Seoven\User\Manager::isManager()&&$client->getTariff()!==false):?>
                                <div class="tarifs-menu-block-name">Ваш тариф: <?=$client->getTariff()['TARIFF']?></div>
                            <?else:?>
                                <div class="tarifs-menu-block-name">Ваш тариф: демо</div>
                                <div class="tarifs-menu-block-button">
                                    <a href="/tarifs" class="submit UIButton-red small">Оплатить</a>
                                </div>
                            <?endif;?>


                        </div>
	                </div>
	                <!--a class="footer-left-menu" href="/about/">
	                    <?=getSVGIcon(SITE_TEMPLATE_PATH. "/assets/images/logo.svg")?>
	                    <div class="link">
	                        О компании
	                    </div>
	                </a-->
	            </div>
				<div class="content-desktop">
					<div class="header">
	                    <div class="left-path">
	                        <div class="title-page">
	                            <?$APPLICATION->ShowTitle(false)?>
	                            <?php if(CSite::InDir("/docs/") || CSite::InDir("/reports/") ||
		                            	CSite::InDir("/manager/docs/") || CSite::InDir("/manager/reports/")) { ?>
	                            	<div class="search-form">
										<form action="" method="post">
											<input type="text" name="q" value="<?=$_REQUEST["q"]?>" placeholder="Поиск">
											<button type="submit"></button>
										</form>
									</div>
								<?php } ?>
	                        </div>

	                        <?/*<div class="download">
	                            <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/icons/other-download.svg"/>
	                            <div class="download-title">
	                                Экспорт динамики
	                            </div>
	                        </div>
	                        */?>
	                    </div>

                        <div class="header-tarif-info">


                            <?if(!Seoven\User\Manager::isManager()&&$client->getTariff()!==false):?>
                                Ваш тариф: <?=$client->getTariff()['TARIFF']?>
                            <?else:?>
                                Ваш тариф: демо   <a href="/tarifs" class="submit UIButton-red small">Оплатить</a>
                            <?endif;?>

                        </div>


		                <?/*{type === 'notebook' && (
		                    <div class="left-path">
		                        <div class="download">
		                            <UIIcon type="i-other-download"/>
		                            <div class="download-title">
		                                Экспорт динамики
		                            </div>
		                        </div>
		                    </div>)}
		                    */?>
		                <div class="right-path">
		                    <div class="actions">
		                        <?/*<div class="action">
		                            <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/icons/other-union.svg"/>
		                        </div>
		                        */?>
		                        <?php if(!Seoven\User\Manager::isManager()) { ?>
		                        <a class="action" href="<?=count($clientNotif) ? "/":"javascript:void(0)" ?>">

		                            <?php if(count($clientNotif)) { ?>
			                            <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/icons/other-notification.svg"/>
			                            <div class="indicator"></div>
			                        <?php } else { ?>
			                        	<img src="<?=SITE_TEMPLATE_PATH?>/assets/images/icons/notification-ico.svg"/>
									<?php } ?>
		                        </a>
		                        <?php } ?>
		                    </div>
		                    <div class="options-avatar">
		                        <div class="avatar">
		                            <div class="wrapper-avatar">
		                                <img src="<?=$clientData["USER"]["UF_AVATAR"]?>" width="40" />
		                            </div>
		                        </div>
		                        <div class="name">
		                            <?=$clientData["USER"]["WORK_COMPANY"] ?: $USER->GetFullName()?>
		                        </div>
		                        <?/*<img class="arrow" src="<?=SITE_TEMPLATE_PATH?>/assets/images/arrow.svg"/>*/?>
		                        <div class="dropdown-menu">
			                    	<ul>
				                    	<li class="dropdown-item"><a href="/profile">Профиль</a></li>
                                        <li class="dropdown-item"><a href="/?logout=yes">Выход</a></li>
			                    	</ul>
		                        </div>
		                    </div>

		                </div>
		            </div>
					<div class="wrapper-mobile-header">
						<a class="logo" href="<?=Seoven\User\Manager::isManager() ? '/projects/' : '/projects/'?>"><img src="<?=SITE_TEMPLATE_PATH?>/assets/images/logo.svg" class="logo" alt="logo"></a>
						<div class="actions">
	                        <?/*<div class="action">
	                            <img src="<?=SITE_TEMPLATE_PATH?>/assets/images/icons/other-union.svg"/>
	                        </div>
	                        */?>
	                        <?php if(!Seoven\User\Manager::isManager()) { ?>
	                        <a class="action" href="<?=count($clientNotif) ? "/":"javascript:void(0)" ?>">

	                            <?php if(count($clientNotif)) { ?>
		                            <?=getSVGIcon(SITE_TEMPLATE_PATH."/assets/images/icons/other-notification.svg")?>
		                            <div class="indicator"></div>
		                        <?php } else { ?>
		                        	<img src="<?=SITE_TEMPLATE_PATH?>/assets/images/icons/notification-ico.svg"/>
								<?php } ?>
	                        </a>
	                        <?php } ?>
	                        <?php if($USER->IsAuthorized()) { ?>
		                        <div class="avatar">
		                            <div class="wrapper-avatar">
		                                <img src="<?=$clientData["USER"]["UF_AVATAR"]?>" width="40" />
		                            </div>
			                        <div class="dropdown-menu">
				                    	<ul>
					                    	<li class="dropdown-item"><a href="/?logout=yes">Выход</a></li>
				                    	</ul>
			                        </div>
		                        </div>
	                        <?php } ?>
	                        <svg type="i-menu-grid" class="burger false" width="39" height="32" viewBox="0 0 39 32" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path fill-rule="evenodd" clip-rule="evenodd" d="M39 10H0V12H39V10ZM39 20H0V22H39V20Z" fill="#141414"/>
							</svg>
	                    </div>
					</div>
					<div class="main-content">
						<div class="title-page mobile">
                            <?$APPLICATION->ShowTitle(false)?>
                            <?php if(CSite::InDir("/docs/") || CSite::InDir("/reports/") ||
	                            	CSite::InDir("/manager/docs/") || CSite::InDir("/manager/reports/")) { ?>
                            	<div class="search-form">
									<form action="" method="post">
										<input type="text" name="q" value="<?=$_REQUEST["q"]?>" placeholder="Поиск">
										<button class="UIButton-red small" type="submit"></button>
									</form>
								</div>
							<?php } ?>
                        </div>
		<?php } ?>
