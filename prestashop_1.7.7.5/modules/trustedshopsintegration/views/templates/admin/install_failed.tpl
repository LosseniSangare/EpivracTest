{*
* 2016-2021 Trusted Shops GmbH
*
* NOTICE OF LICENSE
*  @author    Trusted Shops GmbH
*  @copyright 2016-2021 Trusted Shops GmbH
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*
*}

{if $lang == 'fr'}
    <span>
        Cher(e) utilisateur(trice),<br/>
        Malheureusement, vous utilisez une version PHP non compatible. Pour un fonctionnement optimal, ce module nécessite d’utiliser une version PHP 5.5 ou ultérieure. Si vous souhaitez poursuivre avec une ancienne version, voici
        <a href="{$failed_link|escape:'htmlall':'UTF-8'}" target="blank">un guide</a> sur la façon de procéder.
    </span>
{elseif $lang == 'de'}
    <span>
        Lieber Nutzer,<br/>
        leider verwenden Sie eine nicht kompatible PHP Version. Das Modul setzt mindestens eine Version von PHP 5.5 voraus. Wenn Sie Ihre PHP Version nicht updaten können, finden Sie
        <a href="{$failed_link|escape:'htmlall':'UTF-8'}" target="blank">hier</a> eine Anleitung, wie Sie weiter vorgehen können.
    </span>
{elseif $lang == 'pl'}
    <span>
        Drogi Użytkowniku,<br/>
        niestety nie korzystasz z kompatybilnej wersji PHP. Moduł wymaga co najmniej wersji 5.5. Jeśli nie możesz zaktualizować swojej wersji PHP, tu
        <a href="{$failed_link|escape:'htmlall':'UTF-8'}" target="blank">znajdziesz instrukcje</a>, jak dalej postąpić.
    </span>
{else}
    <span>
        Dear user,<br/>
        unfortunately, you are using a non-compatible PHP version. The module requires at least PHP 5.5. If you cannot update your PHP version, you can find instructions on how to proceed
        <a href="{$failed_link|escape:'htmlall':'UTF-8'}" target="blank">here</a>.
    </span>
{/if}
