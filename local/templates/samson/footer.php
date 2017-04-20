<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
</div><!-- end work-->
</div><!-- end row-->
<div class="row fix_to_bottom">
    <div class="col-xs-3"></div>
    <div class="col-xs-9"> <?$APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            Array(
                "AREA_FILE_SHOW" => "sect",
                "AREA_FILE_SUFFIX" => "inc_footer",
                "AREA_FILE_RECURSIVE" => "Y",
                "EDIT_TEMPLATE" => ""
            )
        );?></div>
</div>
</div><!-- end container-->
<!-------------footer start-------------->
<footer id="footer">
    <div class="container">

        <div class="row">
            <div class="col-xs-3 col-md-3">
                <div id="logo-bot">
                    <a href="/"><img src="/images/logo-orig.gif" class="img-responsive"></a>
                </div>
            </div>
            <div class="col-xs-9 col-md-9">

                <? $APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
                    "AREA_FILE_SHOW" => "file",
                    "PATH" => "/include/copyright.php",
                    "EDIT_TEMPLATE" => ""
                ),
                    false
                ); ?>
            </div>
        </div>
    </div>
</footer>
<!-------------footer end-------------->
<!--counters -->
<? $APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
    "AREA_FILE_SHOW" => "file",
    "PATH" => "/include/counters.php",
    "EDIT_TEMPLATE" => ""
),
    false
); ?>
<script type="text/javascript">
    if (window.location.pathname == '/special/' || window.location.pathname == '/optom/' ) {
        document.querySelector('#work').classList.add('lending')
    }
    if (window.location.pathname == '/') {
        document.querySelector('body').classList.add('front_page')
    }
</script>

</body>
</html>
