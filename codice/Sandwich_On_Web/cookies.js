function scriviCookie(nomeCookie,valoreCookie,durataCookie)
{
  var scadenza = new Date();
  var adesso = new Date();
  scadenza.setTime(adesso.getTime() + (parseInt(durataCookie) * 60000));
  document.cookie = nomeCookie + '=' + escape(valoreCookie) + '; expires=' + scadenza.toGMTString() + '; path = /';
}
function leggiCookie(nomeCookie)
{
  if (document.cookie.length > 0)
  {
    var inizio = document.cookie.indexOf(nomeCookie + "=");
    if (inizio != -1)
    {
      inizio = inizio + nomeCookie.length + 1;
      var fine = document.cookie.indexOf(";",inizio);
      if (fine == -1) fine = document.cookie.length;
      return unescape(document.cookie.substring(inizio,fine));
    }else{
       return "";
    }
  }
  return "";
}
function cancellaCookie(nomeCookie)
{
  scriviCookie(nomeCookie,'',-1);
}
function verificaCookie()
{
  document.cookie = 'verifica_cookie';
  var testcookie = (document.cookie.indexOf('verifica_cookie') != -1) ? true : false;
  return testcookie;
}
