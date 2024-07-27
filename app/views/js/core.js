function myDate() {
    let date = new Date();
        let day = date.getDate();
            let month = date.getMonth();
                let year = date.getFullYear();
                    let hour = date.getHours();
                        let min = date.getMinutes();
                            let sec = date.getSeconds();
    month = month + 1;
        if(day < 10) {
            day = '0' + day;
        }                            
            if(month < 10) {
                month = '0' + month;
            }
                if(hour < 10) {
                    hour = '0' + hour;
                }
                    if(min < 10) {
                        min = '0' + min;
                    }
                        if(sec < 10) {
                            sec = '0' + sec;
                        }                  
    let dateFormat = day + '-' + month + '-' + year + ' ' + hour + ':' + min + ':' + sec;
        return dateFormat;
};