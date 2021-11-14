function toast(msg, type, closer_time){
	if(closer_time == undefined)
		closer_time = 2000;
    MsgPop.displaySmall = true;
    MsgPop.position = "top-left";
    var test = MsgPop.open({
    Type:     type,
    CloseTimer:   closer_time,
    Content:    msg});
}