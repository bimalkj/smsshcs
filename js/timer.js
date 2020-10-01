	function addTimer()
	{
	 	var quiz_time=window.quiz_time;
	 	var time=quiz_time.split(":");
		window.hh=time[0];
		window.mm=time[1];
		window.ss=time[2];
		t=setTimeout("test()",1000);
	}

	function test()
	{
		hh=window.hh;
		mm=window.mm;
		ss=window.ss;
		hh=String(hh);
		if(hh.length==1)
			hh="0"+hh;
		mm=String(mm);
		if(mm.length==1)
			mm="0"+mm;
		ss=window.ss;
		ss=String(ss);
		if(ss.length==1)
			ss="0"+ss;
			
		document.getElementById("newDiv").innerHTML="Time Left:"+hh+":"+mm+":"+ss;
		
		if(ss==0)
		{
			mm=mm-1;
			if(hh==0 && mm==0 && ss==0)
			{
				$( "#dialog-form" ).dialog( "close" );
			}
			ss=60;
		}
		
		if(mm==0 && hh!=0)
		{
			hh=hh-1;
			
			mm=59;
		}
		
		window.ss=window.ss-1;
		t=setTimeout("test()",1000);
	}
	/*window.my_div = null;
	 window.newDiv = null;
	 window.newDiv = document.createElement("div");
	 window.my_div = document.getElementById("pos");
	 document.body.insertBefore(newDiv, my_div);*/