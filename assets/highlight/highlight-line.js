!function(e,t)
{"use strict";
    function n(e,t)
    {if(hljs.hasOwnProperty
    ("initLineNumbersOnLoad"))
        var n=setInterval
        (function()
        {var i=e.getElementsByTagName("table");
            if(0!=i.length){clearInterval(n);
                var r=i[0];r.style.width="100%";
                var l=r.getElementsByClassName
                ("hljs-ln-numbers");
                for(var a of l)a.style.width="2em";if(void 0!==t)
                {var o=e.getElementsByTagName("tr");for(var s of t)for
                (var h=s.start;h<=s.end;++h)o[h].style.backgroundColor=s.color}}},1e3);
        else if(e.innerHTML=e.innerHTML.replace(/[ \S]*\n/gm,function(e)
    {return'<div class="highlight-line">'+e+"</div>"}),void 0!==t)
        {var i=e.getElementsByClassName
        ("highlight-line"),r=e.scrollWidth;
            for(var l of t)for(var a=l.start;a<=l.end;++a)
                i[a].style.backgroundColor=l.color,i[a].style.minWidth=r+"px"}}
    e.hljs&&(e.hljs.initHighlightLinesOnLoad=function(i)
    {function r(){for(var e=t.getElementsByClassName
    ("hljs"),r=0;r<e.length;++r)n(e[r],i[r])}"loading"!==t.readyState?r():e.addEventListener(
        "DOMContentLoaded",function(){r()})}
        ,e.hljs.highlightLinesCode=n)}(window,document);
