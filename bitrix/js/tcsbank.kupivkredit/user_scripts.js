function TCSSetCookie()
{
    TCSExtSetCookie("kupivkredit",1,false,"/");
}
function TCSClearCookie()
{
    TCSExtSetCookie("kupivkredit",0,false,"/");
}

function TCSBuyClick(sID)
{
    if(obj = BX(sID))
    {
        TCSSetCookie();
        obj.click();
    }
}

function TCSExtSetCookie (name, value, expires, path, domain, secure) {
    document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}