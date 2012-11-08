/*! Respond.js: min/max-width media query polyfill. (c) Scott Jehl. MIT/GPLv2 Lic. j.mp/respondjs  */(function(e,t){function w(){g(!0)}e.respond={};respond.update=function(){};respond.mediaQueriesSupported=t;if(t)return;var n=e.document,r=n.documentElement,i=[],s=[],o=[],u={},a=30,f=n.getElementsByTagName("head")[0]||r,l=f.getElementsByTagName("link"),c=[],h=function(){var t=l,n=t.length,r=0,i,s,o,a;for(;r<n;r++){i=t[r],s=i.href,o=i.media,a=i.rel&&i.rel.toLowerCase()==="stylesheet";if(!!s&&a&&!u[s])if(i.styleSheet&&i.styleSheet.rawCssText){d(i.styleSheet.rawCssText,s,o);u[s]=!0}else(!/^([a-zA-Z]+?:(\/\/)?)/.test(s)||s.replace(RegExp.$1,"").split("/")[0]===e.location.host)&&c.push({href:s,media:o})}p()},p=function(){if(c.length){var e=c.shift();y(e.href,function(t){d(t,e.href,e.media);u[e.href]=!0;p()})}},d=function(e,t,n){var r=e.match(/@media[^\{]+\{([^\{\}]+\{[^\}\{]+\})+/gi),o=r&&r.length||0,t=t.substring(0,t.lastIndexOf("/")),u=function(e){return e.replace(/(url\()['"]?([^\/\)'"][^:\)'"]+)['"]?(\))/g,"$1"+t+"$2$3")},a=!o&&n,f=0,l,c,h,p,d;t.length&&(t+="/");a&&(o=1);for(;f<o;f++){l=0;if(a){c=n;s.push(u(e))}else{c=r[f].match(/@media ([^\{]+)\{([\S\s]+?)$/)&&RegExp.$1;s.push(RegExp.$2&&u(RegExp.$2))}p=c.split(",");d=p.length;for(;l<d;l++){h=p[l];i.push({media:h.match(/(only\s+)?([a-zA-Z]+)(\sand)?/)&&RegExp.$2,rules:s.length-1,minw:h.match(/\(min\-width:[\s]*([\s]*[0-9]+)px[\s]*\)/)&&parseFloat(RegExp.$1),maxw:h.match(/\(max\-width:[\s]*([\s]*[0-9]+)px[\s]*\)/)&&parseFloat(RegExp.$1)})}}g()},v,m,g=function(e){var t="clientWidth",u=r[t],c=n.compatMode==="CSS1Compat"&&u||n.body[t]||u,h={},p=n.createDocumentFragment(),d=l[l.length-1],y=(new Date).getTime();if(e&&v&&y-v<a){clearTimeout(m);m=setTimeout(g,a);return}v=y;for(var b in i){var w=i[b];if(!w.minw&&!w.maxw||(!w.minw||w.minw&&c>=w.minw)&&(!w.maxw||w.maxw&&c<=w.maxw)){h[w.media]||(h[w.media]=[]);h[w.media].push(s[w.rules])}}for(var b in o)o[b]&&o[b].parentNode===f&&f.removeChild(o[b]);for(var b in h){var E=n.createElement("style"),S=h[b].join("\n");E.type="text/css";E.media=b;E.styleSheet?E.styleSheet.cssText=S:E.appendChild(n.createTextNode(S));p.appendChild(E);o.push(E)}f.insertBefore(p,d.nextSibling)},y=function(e,t){var n=b();if(!n)return;n.open("GET",e,!0);n.onreadystatechange=function(){if(n.readyState!=4||n.status!=200&&n.status!=304)return;t(n.responseText)};if(n.readyState==4)return;n.send(null)},b=function(){var e=!1;try{e=new XMLHttpRequest}catch(t){e=new ActiveXObject("Microsoft.XMLHTTP")}return function(){return e}}();h();respond.update=h;e.addEventListener?e.addEventListener("resize",w,!1):e.attachEvent&&e.attachEvent("onresize",w)})(this,function(e){if(e.matchMedia)return!0;var t,n=document,r=n.documentElement,i=r.firstElementChild||r.firstChild,s=!n.body,o=n.body||n.createElement("body"),u=n.createElement("div"),a="only all";u.id="mq-test-1";u.style.cssText="position:absolute;top:-99em";o.appendChild(u);u.innerHTML='_<style media="'+a+'"> #mq-test-1 { width: 9px; }</style>';s&&r.insertBefore(o,i);u.removeChild(u.firstChild);t=u.offsetWidth==9;s?r.removeChild(o):o.removeChild(u);return t}(this));