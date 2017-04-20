<html><head> 
<meta name="yandex-verification" content="5be335d276d1de8e">
<meta http-equiv="content-type" content="text/html; charset=windows-1251">
<link rel="SHORTCUT ICON" href="/favicon.ico" type="image/x-icon"> 

<title><?$APPLICATION->ShowTitle();?></title>
<?$APPLICATION->ShowHead();?>
<script type="text/javascript" src="/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript">
    $(document).ready(
        function(){
            buy_btns = $('a[href*="ADD2BASKET"]');
            buy_btns.each(
                function(){
                    $(this).attr("rel", $(this).attr("href"));
                }
            );
            buy_btns.attr("href","javascript:void(0);");

            $('a[rel*="ADD2BASKET"]').click(                
                function(){
                    $.ajax({
                      type: "GET",
                      url: $(this).attr("rel"),
                      dataType: "html",
                      success: function(out){
                                $("#basket_id").html($(out).find("#basket_id").html());
                                $("#bbb").show();
                      }

                    });
                }
            );
            
        }
    );

</script>
</head> 
<body style="padding-left:55px;padding-top:40px;padding-right:55px;"><iframe name="RemoteIframe" allowtransparency="true" style="position: absolute; left: -999px; top: -999px; width: 1px; height: 1px;"></iframe><link type="text/css" rel="Stylesheet" href="/cms/admin/skins/default/css/admin_pages.css"><script>
var dostavka=0;

function pereshet()
{
$('span.cost').text((cost+dostavka)+' руб');
}
function histiry(id)
{
pereshet();
//$('#outer > div').hide();

for (i=0;i<5;i++)
{
$('#l'+i).css('color','#000066');
$('div.g'+i).hide();
}

$('div.g'+id).fadeIn(800);
$('#l'+id).css('color','#FF0000');
}

function rcolor(id)
{

for (i=0;i<11;i++)
{
$('#e'+i).hide();
$('#s'+i).css('color','#000');
$('#s'+i).css('fontWeight','normal');
}
$('#e'+id).fadeIn(200);
$('#s'+id).css('color','#FF0000');
$('#s'+id).css('fontWeight','bold');
}
</script>
<style>
#kur, .hkur, .info
{
color:#000066;
}
.hkur{font-weight:normal;margin-top:15px;margin-bottom:5px;}
.info
{
font-size:14px;
}
.hta
{
font-size:11px;

}
.d
{
white-space: nowrap ;
margin-bottom:5px;
}

#tk, #kur, .ee
{color:#666666;background-image:URL(/images/bbg.gif);
padding:25px
}
.dcost
{
text-align:center;
font-weight:bold;
color:#666;
}
.dcost2
{
text-align:left;
font-weight:bold;
color:#666;
}
.cost
{
color:#FF0000;
}
.dan
{
line-height:35px;
color:#666;
padding-left:5px;
}
.gt
{
width:100%;
}

.gt .inp{width:100%;}
</style>

