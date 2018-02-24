function startTime()
{
	var today=new Date()
	var year = today.getFullYear()
	var month = today.getMonth()+1
	var day = today.getDate()
	var week = today.getDay()
	month = checkTime(month)
	day = checkTime(day)
	
	var h=today.getHours()
	var m=today.getMinutes()
	var s=today.getSeconds()
	// add a zero in front of numbers<10
	h=checkTime(h)
	m=checkTime(m)
	s=checkTime(s)

	//week
	var weekday=new Array(7)
	weekday[0]="星期日"
	weekday[1]="星期一"
	weekday[2]="星期二"
	weekday[3]="星期三"
	weekday[4]="星期四"
	weekday[5]="星期五"
	weekday[6]="星期六"

	document.getElementById('date').innerHTML=year+'-'+month+'-'+day+' '+h+":"+m+":"+s+'  '+weekday[week]
	t=setTimeout('startTime()',500)
}

function checkTime(i)
{
	if (i<10) 
	{
		i="0" + i
	}
	return i
}

document.getElementsByTagName('body').onload=startTime();