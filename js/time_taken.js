// JavaScript Document
	window.interval=1000;
	function StartTimer()
	{
		window.hour=0;
		window.minute=0;
		window.second=0;
		window.time_taken=0;
		a=setTimeout("increment()",window.interval);
	}

	function increment()
	{
		hour=window.hour;
		minute=window.minute;
		second=window.second;
		hour=String(hour);
		if(hour.length==1)
			hour="0"+hour;
		minute=String(minute);
		if(minute.length==1)
			minute="0"+minute;
		second=window.second;
		second=String(second);
		if(second.length==1)
			second="0"+second;
			
		window.time_taken=hour+":"+minute+":"+second;
		//document.getElementById("newDiv").innerHTML=hour+":"+minute+":"+second;
		hour=Number(hour);
		minute=Number(minute);
		second=Number(second);
		second=second+1;
		
		if(second==60)
		{
			minute=minute+1;
			second=0;
		}
		
		if(minute==60)
		{
			hour=hour+1;
			minute=0;
		}
		
		a=setTimeout("increment()",window.interval);
	}
	
	function StopTimer()
	{
		clearTimeout(a);
	}