
  var viewMode = 1; // WYSIWYG

  function iniciar()
  {
    iView.document.designMode = 'On';
  }
  
  function selOn(ctrl)
  {
	ctrl.style.borderColor = '#000000';
	ctrl.style.backgroundColor = '#B5BED6';
	ctrl.style.cursor = 'hand';	
  }
  
  function selOff(ctrl)
  {
	ctrl.style.borderColor = '#D6D3CE';  
	ctrl.style.backgroundColor = '#D6D3CE';
  }
  
  function selDown(ctrl)
  {
	ctrl.style.backgroundColor = '#8492B5';
  }
  
  function selUp(ctrl)
  {
    ctrl.style.backgroundColor = '#B5BED6';
  }
    
  function doBold()
  {
	iView.document.execCommand('bold', false, null);
  }

  function doItalic()
  {
	iView.document.execCommand('italic', false, null);
  }

  function doUnderline()
  {
	iView.document.execCommand('underline', false, null);
  }
  
  function doLeft()
  {
    iView.document.execCommand('justifyleft', false, null);
  }

  function doCenter()
  {
    iView.document.execCommand('justifycenter', false, null);
  }

  function doRight()
  {
    iView.document.execCommand('justifyright', false, null);
  }

  function doOrdList()
  {
    iView.document.execCommand('insertorderedlist', false, null);
  }

  function doBulList()
  {
    iView.document.execCommand('insertunorderedlist', false, null);
  }
  
  function doForeCol()
  {
   formulario=document.forms[formnumber];
   var fCol= formulario.colourp.value;
    if(fCol != null)
      iView.document.execCommand('forecolor', false, fCol);
  }

  function doBackCol()
  {
    formulario=document.forms[formnumber];
    var bCol = formulario.colourp.value;
    
    if(bCol != null)
      iView.document.execCommand('backcolor', false, bCol);
  }

  function doLink()
  {
    iView.document.execCommand('createlink');
  }
  
  function doImage()
  {
    var imgSrc = prompt('Enter image location', '');
    
    if(imgSrc != null)    
     iView.document.execCommand('insertimage', false, imgSrc);
  }
  
  function doRule()
  {
    iView.document.execCommand('inserthorizontalrule', false, null);
  }
  
  function doFont(fName)
  {
    if(fName != '')
      iView.document.execCommand('fontname', false, fName);
  }
 
  function doSize(fSize)
  {
    if(fSize != '')
      iView.document.execCommand('fontsize', false, fSize);
  }
  function doToggleView()
  {  
    formulario=document.forms[formnumber];
    if(viewMode == 1)
    {
      iHTML = iView.document.body.innerHTML;
      iView.document.body.innerText = iHTML;
      
      // Hide all controls
      tblCtrls.style.display = 'none';
      formulario.selFont.style.display = 'none';
      formulario.selSize.style.display = 'none';
      iView.focus();
      
      viewMode = 2; // Code
    }
    else
    {
      iText = iView.document.body.innerText;
      iView.document.body.innerHTML = iText;
      
      // Show all controls
      tblCtrls.style.display = 'inline';
      formulario.selFont.style.display = 'inline';
      formulario.selSize.style.display = 'inline';
      iView.focus();
      
      viewMode = 1; // WYSIWYG
    }
  }
function ColorPalette_OnClick(colorString)
{
  formulario=document.forms[formnumber];
  document.getElementById("cpick").bgColor=colorString;
  formulario.colourp.value=colorString;
}