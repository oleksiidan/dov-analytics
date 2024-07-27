<div class="modal fade" tabindex="-1" id="mod_analytics_view">
  <div class="modal-dialog">
    <div class="modal-content">

<a id="top"></a>

<div class="modal-header 1bb sticky-top" style="background-color: white;">
    <h5 class="modal-title">   
        <a href="1"
           target="_blank"
           class="text-decoration-none text-primary 1fst-italic 1text-black text-end"
           id="href">
                <i class="bi bi-globe-americas pe-1"></i>
                    <span id="url_project"></span>
        </a>
    </h5>
        <button type="button"
                class="btn-close 1bb 1me-1"
                data-bs-dismiss="modal"
                aria-label="Close"
                style="margin-right: 1px;">
        </button>
</div>

<div class="text-center fst-italic mt-2 px-3 text-secondary help">
    Сlick on a user to see details. For security reasons, some data may be hidden.
</div>
 
<div id="key_name" hidden></div>
    <div class="container 1pt-3 1bb">

    <!-- Count + list day -->
    <div class="row 1mt-1 1bb my-3">     
        
    <!-- Count dashbord -->
        <div class="col-5 1mb-4 1bb text-end" id="updateAnalytics">
              <div class="row">
                <div class="col-auto mx-auto"> 
                    <div class="col 1bb fs-5"><i class="bi bi-arrow-repeat pe-2"></i>Count: <span id="count"></span></div>
                    <div class="col 1bb">
                        <span class="fst-italic"
                                style="font-size: 14px;">Reg:</span> <span style="font-size: 14px"; id="reg"></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- List days  -->
        <div class="col-7 pt-2 1pe-3 1bb" style="padding-right: 12px;">
            <form id="formSelUsers">
                <select class="form-select"
                aria-label="Default select example"
                name="usersSel"
                id="selectPeriod">
                    <option value="today" selected>Today</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="current_month">Current month</option>
                    <option value="last_month">Last month</option>
                </select>
            </form>
        </div>     
    
    </div>


<div id="pastApi"></div>

<!-- Card data analytics -->
<div class="container col text-center mb-4 1bb border rounded position-relative" style="display: none;" id="card">
             
<span class="position-absolute top-0 start-1 translate-middle badge rounded-pill bg-success" style="display: none;">
            Online
        </span>

        <!-- Main info -->
        <div class="row text-secondary 1fst-italic mt-2 1bb 1px-1">  
                <div class="col-6 text-start 1ps-2 1bb fst-italic 1text-secondary" 1id="city">
                    <span id="country"></span>
                </div>
                <div class="col-6 text-end 1pe-2" id="date_activity"></div> 
        </div>

        <div class="row 1fs-5 pt-2 pb-4">
        
        <div class="col-8" id="email"></div>
            <div class="col-3" id="activity_score"></div> 
        
        </div>

    <!-- More details -->
    <div class="1bb details" style="display: none;">

        <div class="col-11 border-top mb-1 mx-auto"></div>

    <div class="col fst-italic mb-2">
        <span class="fw-medium">City:</span>
        "<span id="city"></span>"
    </div>

        <div class="col-11 border-top mb-1 mx-auto"></div>

    <div class="col fst-italic mb-2">
        <span class="fw-medium">Region:</span>
        "<span id="region"></span>"
    </div>

        <div class="col-11 border-top mb-1 mx-auto"></div>

    <div class="col fst-italic mb-2">
        <span class="fw-medium">Language:</span>
        "<span id="lang"></span>"
    </div>

        <div class="col-11 border-top mb-1 mx-auto"></div>

    <div class="col fst-italic mb-2">
        <span class="fw-medium">Isp:</span>
        "<span id="isp"></span>"
    </div>

        <div class="col-11 border-top mb-1 mx-auto"></div>

    <div class="col fst-italic mb-2">
        <span class="fw-medium">Ip:</span>
        "<span id="ip"></span>"
    </div>
                    
        <div class="col-11 border-top mb-1 mx-auto"></div>
                    
    <div class="row 1text-secondary fst-italic mb-2">
        <div class="col">
            <span class="fw-medium">Device:</span>
            "<span id="device"></span>"
        </div>
    </div>

        <div class="col-11 border-top mb-1 mx-auto"></div>

    <div class="row 1text-secondary fst-italic mb-2">
        <div class="col">
            <span class="fw-medium">OS:</span>
            "<span id="os"></span>"
        </div>
    </div>

        <div class="col-11 border-top mb-1 mx-auto"></div>

    <div class="row 1text-secondary fst-italic mb-2">
        <div class="col">
            <span class="fw-medium">Browser:</span>
            "<span id="browser"></span>"
        </div>
    </div>

        <div class="col-11 border-top mb-1 mx-auto"></div>

    <div class="row 1text-secondary fst-italic mb-2">
        <div class="col">
            <span class="fw-medium">Referer:</span>
            "<span id="referer"></span>"
        </div>
    </div>
                        
</div>
<!-- / More details -->        
</div>
<!-- / Card data analytics -->

    <!-- No visitors today  -->
    <div class="col mb-4" style="display: none;" id="no_data">
        <div class="col text-center mt-2 py-5 border rounded 1text-secondary 1fs-5 fst-italic">
        No visits for the selected period ...
                </div>
    </div>
</div>

    <!-- Arrow up -->
    <div class="sticky-bottom text-end pe-2">
        <a href="#top">
        <i class="bi bi-arrow-up-circle" style="font-size: 45px; color: lightgrey;"></i>
        </a>
    </div>

        </div>
   
    </div>
  </div>
</div>