<?php
namespace PayMee;
include_once("BasicEnum.class.php");
abstract class CheckoutType extends BasicEnum
{
    const SEMI_TRANSPARENT = "SEMI_TRANSPARENT";
    const GATEWAY = "GATEWAY";
}
?>