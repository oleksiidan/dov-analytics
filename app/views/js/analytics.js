async function getAnalytics(project, period = 'today') {

    let requestData = {"project": project, "period": period};

    let response = await fetch (
                'https://dov.pp.ua/analytics',
                {
                    method: 'POST',  
                    headers:
                            {
                                'Content-Type': 'application/json;charset=utf-8'
                            },
                    body: JSON.stringify(requestData)
                }
            );

    let data = await response.json();

        // Card
        let cardKeys = ["lang","country","city","region","date_activity","email","activity_score",
            "device","os","browser","referer","isp","ip"];

            // Clear cards
            $('#pastApi').html(null);
        

            // Check data exists
            if(data['count']['total'] == 0)
            {
                let cloneNoData = $('#no_data').clone();
                    
                        $('#pastApi').append(cloneNoData.toggle().removeAttr('id'));
            }
            else 
            {    
                // Create card with data
                for (i in data['users'])
                {   
                    // Data filling
                    for(x in cardKeys)
                    {

                        // Check if no data available
                        if(data['users'][i][cardKeys[x]] == null)
                        {
                            $('#card').find('#'+ [cardKeys[x]]).html('<span class="text-secondary">Data not available</span>');  
                        }
                        else
                        {
                            $('#card').find('#'+ [cardKeys[x]]).html(data['users'][i][cardKeys[x]]);
                        } 
                    
                    }
                            
                        let clone = $('#card').clone();

                        // Past card
                        $('#pastApi').append(clone.toggle().removeAttr('id')); 

                        // Mark registered users
                        if(data['users'][i]['token'])
                        {
                            clone.addClass("border-success");
                        }   
  
                        // Mark online users
                        if(data['users'][i]['online'])
                        {
                            clone.children().first().show();
                        }

                        // Click see details
                        clone.on('click', function() {
                            clone.find('.details').toggle();
                        });        
                }
            }     
                            // Url, href and key_name
                            let url = $('#url_project').html(null);
                                url.append(data['project']['url']);
                            // Href
                            let href = $('#href');
                                href['0']['href'] = ['project']['url'];
                            // Key_name
                            let keyName = $('#key_name');
                                keyName.html(data['project']['key_name']);

                            // Time
                            // let time = $('#timeAnalytics');
                            //     time.html(data[i]['time']);

                            // Count
                            $('#count').html(data['count']['total']);
                                // $('#unreg').html(data[i]['count']['unreg']);
                                    $('#reg').html(data['count']['reg']);

        $('#mod_analytics_view').modal('show');
}

function showMain() {
    document.getElementById('mainContent').hidden = false;
        document.getElementById('analytics').hidden = true;
}

function selectPeriod() {
    let selectPeriod = $('#selectPeriod');      
        selectPeriod.change(function() {
            let period = selectPeriod.val();
                let project = $('#key_name').html();
                    getAnalytics(project, period) 
        });
}

function helpHide() {
    if($('#email').html() == 'danishevskij@gmail.com')
    {
        $('.help').hide();
    }  
}

function pressUpdateAnalytics() {
    let period = $('#selectPeriod').val();
        let project = $('#key_name').html();
            getAnalytics(project, period);
}

function autostart() {

    // Add listener to id updateAnalytics
    $('#updateAnalytics').on('click', function(){
        pressUpdateAnalytics();
    });

    // Run autostart function
    selectPeriod();
        helpHide();
}

autostart();
