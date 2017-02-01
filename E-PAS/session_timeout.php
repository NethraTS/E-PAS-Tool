<head>
</head>
<body>
<style type="text/css">  
		.modal-dialog {
        left: 0px;  
        top: 90px;
        right: 100px; 
      }
      .modal.fade {
        background:rgb(0,0,0);  
        background: transparent\9;  
        background:rgba(0,0,0,0.4);      
      }
    </style>

<div id="mod" class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-body">
	 Session Expired
	 </div>
	 <div class="modal-footer">
	 <input type="button" class="btn btn-primary" name="ok" onclick="logout()" value="Ok"/></input>
	 </div>
    </div>
  </div>
</div>
<script type="text/javascript" >
var IDLE_TIMEOUT = 1000; //seconds
var _idleSecondsTimer = null;
var _idleSecondsCounter = 0;
document.onclick = function() {
    _idleSecondsCounter = 0;
};

document.onmousemove = function() {
    _idleSecondsCounter = 0;
};

document.onkeypress = function() {
    _idleSecondsCounter = 0;
};

_idleSecondsCounter = window.setInterval(CheckIdleTime, 300);

function CheckIdleTime() {
     _idleSecondsCounter++;
     var oPanel = document.getElementById("SecondsUntilExpire");
     if (oPanel)
     oPanel.innerHTML = (IDLE_TIMEOUT - _idleSecondsCounter) + "";
    if (_idleSecondsCounter >= IDLE_TIMEOUT) {
        window.clearInterval(_idleSecondsCounter);
    $('#mod').modal('show');
    }
}
function logout()
{
	document.location.href = "index.php";
	//header("Location:index.php");
}
</script>
</body>
</html>