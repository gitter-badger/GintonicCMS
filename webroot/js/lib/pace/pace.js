/*! pace 1.0.0 */

(function(){var e,t,n,r,i,s,o,u,a,f,l,c,h,p,d,v,m,g,y,b,w,E,S,x,T,N,C,k,L,A,O,M,_,D,P,H,B,j,F,I,q,R,U,z,W,X,V,$,J,K=[].slice,Q={}.hasOwnProperty,G=function(e,t){function n(){this.constructor=e}for(var r in t)Q.call(t,r)&&(e[r]=t[r]);return n.prototype=t.prototype,e.prototype=new n,e.__super__=t.prototype,e},Y=[].indexOf||function(e){for(var t=0,n=this.length;n>t;t++)if(t in this&&this[t]===e)return t;return-1};for(w={catchupTime:100,initialRate:.03,minTime:250,ghostTime:100,maxProgressPerFrame:20,easeFactor:1.25,startOnPageLoad:!0,restartOnPushState:!0,restartOnRequestAfter:500,target:"body",elements:{checkInterval:100,selectors:["body"]},eventLag:{minSamples:10,sampleCount:3,lagThreshold:3},ajax:{trackMethods:["GET"],trackWebSockets:!0,ignoreURLs:[]}},L=function(){var e;return null!=(e="undefined"!=typeof performance&&null!==performance&&"function"==typeof performance.now?performance.now():void 0)?e:+(new Date)},O=window.requestAnimationFrame||window.mozRequestAnimationFrame||window.webkitRequestAnimationFrame||window.msRequestAnimationFrame,b=window.cancelAnimationFrame||window.mozCancelAnimationFrame,null==O&&(O=function(e){return setTimeout(e,50)},b=function(e){return clearTimeout(e)}),_=function(e){var t,n;return t=L(),(n=function(){var r;return r=L()-t,r>=33?(t=L(),e(r,function(){return O(n)})):setTimeout(n,33-r)})()},M=function(){var e,t,n;return n=arguments[0],t=arguments[1],e=3<=arguments.length?K.call(arguments,2):[],"function"==typeof n[t]?n[t].apply(n,e):n[t]},E=function(){var e,t,n,r,i,s,o;for(t=arguments[0],r=2<=arguments.length?K.call(arguments,1):[],s=0,o=r.length;o>s;s++)if(n=r[s])for(e in n)Q.call(n,e)&&(i=n[e],null!=t[e]&&"object"==typeof t[e]&&null!=i&&"object"==typeof i?E(t[e],i):t[e]=i);return t},m=function(e){var t,n,r,i,s;for(n=t=0,i=0,s=e.length;s>i;i++)r=e[i],n+=Math.abs(r),t++;return n/t},x=function(e,t){var n,r,i;if(null==e&&(e="options"),null==t&&(t=!0),i=document.querySelector("[data-pace-"+e+"]")){if(n=i.getAttribute("data-pace-"+e),!t)return n;try{return JSON.parse(n)}catch(s){return r=s,"undefined"!=typeof console&&null!==console?console.error("Error parsing inline pace options",r):void 0}}},o=function(){function e(){}return e.prototype.on=function(e,t,n,r){var i;return null==r&&(r=!1),null==this.bindings&&(this.bindings={}),null==(i=this.bindings)[e]&&(i[e]=[]),this.bindings[e].push({handler:t,ctx:n,once:r})},e.prototype.once=function(e,t,n){return this.on(e,t,n,!0)},e.prototype.off=function(e,t){var n,r,i;if(null!=(null!=(r=this.bindings)?r[e]:void 0)){if(null==t)return delete this.bindings[e];for(n=0,i=[];n<this.bindings[e].length;)i.push(this.bindings[e][n].handler===t?this.bindings[e].splice(n,1):n++);return i}},e.prototype.trigger=function(){var e,t,n,r,i,s,o,u,a;if(n=arguments[0],e=2<=arguments.length?K.call(arguments,1):[],null!=(o=this.bindings)?o[n]:void 0){for(i=0,a=[];i<this.bindings[n].length;)u=this.bindings[n][i],r=u.handler,t=u.ctx,s=u.once,r.apply(null!=t?t:this,e),a.push(s?this.bindings[n].splice(i,1):i++);return a}},e}(),f=window.Pace||{},window.Pace=f,E(f,o.prototype),A=f.options=E({},w,window.paceOptions,x()),V=["ajax","document","eventLag","elements"],U=0,W=V.length;W>U;U++)B=V[U],A[B]===!0&&(A[B]=w[B]);a=function(e){function t(){return $=t.__super__.constructor.apply(this,arguments)}return G(t,e),t}(Error),t=function(){function e(){this.progress=0}return e.prototype.getElement=function(){var e;if(null==this.el){if(e=document.querySelector(A.target),!e)throw new a;this.el=document.createElement("div"),this.el.className="pace pace-active",document.body.className=document.body.className.replace(/pace-done/g,""),document.body.className+=" pace-running",this.el.innerHTML='<div class="pace-progress">\n  <div class="pace-progress-inner"></div>\n</div>\n<div class="pace-activity"></div>',null!=e.firstChild?e.insertBefore(this.el,e.firstChild):e.appendChild(this.el)}return this.el},e.prototype.finish=function(){var e;return e=this.getElement(),e.className=e.className.replace("pace-active",""),e.className+=" pace-inactive",document.body.className=document.body.className.replace("pace-running",""),document.body.className+=" pace-done"},e.prototype.update=function(e){return this.progress=e,this.render()},e.prototype.destroy=function(){try{this.getElement().parentNode.removeChild(this.getElement())}catch(e){a=e}return this.el=void 0},e.prototype.render=function(){var e,t,n,r,i,s,o;if(null==document.querySelector(A.target))return!1;for(e=this.getElement(),r="translate3d("+this.progress+"%, 0, 0)",o=["webkitTransform","msTransform","transform"],i=0,s=o.length;s>i;i++)t=o[i],e.children[0].style[t]=r;return(!this.lastRenderedProgress||this.lastRenderedProgress|0!==this.progress|0)&&(e.children[0].setAttribute("data-progress-text",""+(0|this.progress)+"%"),this.progress>=100?n="99":(n=this.progress<10?"0":"",n+=0|this.progress),e.children[0].setAttribute("data-progress",""+n)),this.lastRenderedProgress=this.progress},e.prototype.done=function(){return this.progress>=100},e}(),u=function(){function e(){this.bindings={}}return e.prototype.trigger=function(e,t){var n,r,i,s,o;if(null!=this.bindings[e]){for(s=this.bindings[e],o=[],r=0,i=s.length;i>r;r++)n=s[r],o.push(n.call(this,t));return o}},e.prototype.on=function(e,t){var n;return null==(n=this.bindings)[e]&&(n[e]=[]),this.bindings[e].push(t)},e}(),R=window.XMLHttpRequest,q=window.XDomainRequest,I=window.WebSocket,S=function(e,t){var n,r,i,s;s=[];for(r in t.prototype)try{i=t.prototype[r],s.push(null==e[r]&&"function"!=typeof i?e[r]=i:void 0)}catch(o){n=o}return s},C=[],f.ignore=function(){var e,t,n;return t=arguments[0],e=2<=arguments.length?K.call(arguments,1):[],C.unshift("ignore"),n=t.apply(null,e),C.shift(),n},f.track=function(){var e,t,n;return t=arguments[0],e=2<=arguments.length?K.call(arguments,1):[],C.unshift("track"),n=t.apply(null,e),C.shift(),n},H=function(e){var t;if(null==e&&(e="GET"),"track"===C[0])return"force";if(!C.length&&A.ajax){if("socket"===e&&A.ajax.trackWebSockets)return!0;if(t=e.toUpperCase(),Y.call(A.ajax.trackMethods,t)>=0)return!0}return!1},l=function(e){function t(){var e,n=this;t.__super__.constructor.apply(this,arguments),e=function(e){var t;return t=e.open,e.open=function(r,i){return H(r)&&n.trigger("request",{type:r,url:i,request:e}),t.apply(e,arguments)}},window.XMLHttpRequest=function(t){var n;return n=new R(t),e(n),n};try{S(window.XMLHttpRequest,R)}catch(r){}if(null!=q){window.XDomainRequest=function(){var t;return t=new q,e(t),t};try{S(window.XDomainRequest,q)}catch(r){}}if(null!=I&&A.ajax.trackWebSockets){window.WebSocket=function(e,t){var r;return r=null!=t?new I(e,t):new I(e),H("socket")&&n.trigger("request",{type:"socket",url:e,protocols:t,request:r}),r};try{S(window.WebSocket,I)}catch(r){}}}return G(t,e),t}(u),z=null,T=function(){return null==z&&(z=new l),z},P=function(e){var t,n,r,i;for(i=A.ajax.ignoreURLs,n=0,r=i.length;r>n;n++)if(t=i[n],"string"==typeof t){if(-1!==e.indexOf(t))return!0}else if(t.test(e))return!0;return!1},T().on("request",function(t){var n,r,i,s,o;return s=t.type,i=t.request,o=t.url,P(o)?void 0:f.running||A.restartOnRequestAfter===!1&&"force"!==H(s)?void 0:(r=arguments,n=A.restartOnRequestAfter||0,"boolean"==typeof n&&(n=0),setTimeout(function(){var t,n,o,u,a,l;if(t="socket"===s?i.readyState<2:0<(u=i.readyState)&&4>u){for(f.restart(),a=f.sources,l=[],n=0,o=a.length;o>n;n++){if(B=a[n],B instanceof e){B.watch.apply(B,r);break}l.push(void 0)}return l}},n))}),e=function(){function e(){var e=this;this.elements=[],T().on("request",function(){return e.watch.apply(e,arguments)})}return e.prototype.watch=function(e){var t,n,r,i;return r=e.type,t=e.request,i=e.url,P(i)?void 0:(n="socket"===r?new p(t):new d(t),this.elements.push(n))},e}(),d=function(){function e(e){var t,n,r,i,s,o,u=this;if(this.progress=0,null!=window.ProgressEvent)for(n=null,e.addEventListener("progress",function(e){return u.progress=e.lengthComputable?100*e.loaded/e.total:u.progress+(100-u.progress)/2},!1),o=["load","abort","timeout","error"],r=0,i=o.length;i>r;r++)t=o[r],e.addEventListener(t,function(){return u.progress=100},!1);else s=e.onreadystatechange,e.onreadystatechange=function(){var t;return 0===(t=e.readyState)||4===t?u.progress=100:3===e.readyState&&(u.progress=50),"function"==typeof s?s.apply(null,arguments):void 0}}return e}(),p=function(){function e(e){var t,n,r,i,s=this;for(this.progress=0,i=["error","open"],n=0,r=i.length;r>n;n++)t=i[n],e.addEventListener(t,function(){return s.progress=100},!1)}return e}(),r=function(){function e(e){var t,n,r,s;for(null==e&&(e={}),this.elements=[],null==e.selectors&&(e.selectors=[]),s=e.selectors,n=0,r=s.length;r>n;n++)t=s[n],this.elements.push(new i(t))}return e}(),i=function(){function e(e){this.selector=e,this.progress=0,this.check()}return e.prototype.check=function(){var e=this;return document.querySelector(this.selector)?this.done():setTimeout(function(){return e.check()},A.elements.checkInterval)},e.prototype.done=function(){return this.progress=100},e}(),n=function(){function e(){var e,t,n=this;this.progress=null!=(t=this.states[document.readyState])?t:100,e=document.onreadystatechange,document.onreadystatechange=function(){return null!=n.states[document.readyState]&&(n.progress=n.states[document.readyState]),"function"==typeof e?e.apply(null,arguments):void 0}}return e.prototype.states={loading:0,interactive:50,complete:100},e}(),s=function(){function e(){var e,t,n,r,i,s=this;this.progress=0,e=0,i=[],r=0,n=L(),t=setInterval(function(){var o;return o=L()-n-50,n=L(),i.push(o),i.length>A.eventLag.sampleCount&&i.shift(),e=m(i),++r>=A.eventLag.minSamples&&e<A.eventLag.lagThreshold?(s.progress=100,clearInterval(t)):s.progress=100*(3/(e+3))},50)}return e}(),h=function(){function e(e){this.source=e,this.last=this.sinceLastUpdate=0,this.rate=A.initialRate,this.catchup=0,this.progress=this.lastProgress=0,null!=this.source&&(this.progress=M(this.source,"progress"))}return e.prototype.tick=function(e,t){var n;return null==t&&(t=M(this.source,"progress")),t>=100&&(this.done=!0),t===this.last?this.sinceLastUpdate+=e:(this.sinceLastUpdate&&(this.rate=(t-this.last)/this.sinceLastUpdate),this.catchup=(t-this.progress)/A.catchupTime,this.sinceLastUpdate=0,this.last=t),t>this.progress&&(this.progress+=this.catchup*e),n=1-Math.pow(this.progress/100,A.easeFactor),this.progress+=n*this.rate*e,this.progress=Math.min(this.lastProgress+A.maxProgressPerFrame,this.progress),this.progress=Math.max(0,this.progress),this.progress=Math.min(100,this.progress),this.lastProgress=this.progress,this.progress},e}(),j=null,D=null,g=null,F=null,v=null,y=null,f.running=!1,N=function(){return A.restartOnPushState?f.restart():void 0},null!=window.history.pushState&&(X=window.history.pushState,window.history.pushState=function(){return N(),X.apply(window.history,arguments)}),null!=window.history.replaceState&&(J=window.history.replaceState,window.history.replaceState=function(){return N(),J.apply(window.history,arguments)}),c={ajax:e,elements:r,document:n,eventLag:s},(k=function(){var e,n,r,i,s,o,u,a;for(f.sources=j=[],o=["ajax","elements","document","eventLag"],n=0,i=o.length;i>n;n++)e=o[n],A[e]!==!1&&j.push(new c[e](A[e]));for(a=null!=(u=A.extraSources)?u:[],r=0,s=a.length;s>r;r++)B=a[r],j.push(new B(A));return f.bar=g=new t,D=[],F=new h})(),f.stop=function(){return f.trigger("stop"),f.running=!1,g.destroy(),y=!0,null!=v&&("function"==typeof b&&b(v),v=null),k()},f.restart=function(){return f.trigger("restart"),f.stop(),f.start()},f.go=function(){var e;return f.running=!0,g.render(),e=L(),y=!1,v=_(function(t,n){var r,i,s,o,u,a,l,c,p,d,v,m,b,w,E,S;for(c=100-g.progress,i=v=0,s=!0,a=m=0,w=j.length;w>m;a=++m)for(B=j[a],d=null!=D[a]?D[a]:D[a]=[],u=null!=(S=B.elements)?S:[B],l=b=0,E=u.length;E>b;l=++b)o=u[l],p=null!=d[l]?d[l]:d[l]=new h(o),s&=p.done,p.done||(i++,v+=p.tick(t));return r=v/i,g.update(F.tick(t,r)),g.done()||s||y?(g.update(100),f.trigger("done"),setTimeout(function(){return g.finish(),f.running=!1,f.trigger("hide")},Math.max(A.ghostTime,Math.max(A.minTime-(L()-e),0)))):n()})},f.start=function(e){E(A,e),f.running=!0;try{g.render()}catch(t){a=t}return document.querySelector(".pace")?(f.trigger("start"),f.go()):setTimeout(f.start,50)},"function"==typeof define&&define.amd?define([],function(){return f}):"object"==typeof exports?module.exports=f:A.startOnPageLoad&&f.start()}).call(this);