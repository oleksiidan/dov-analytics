{% extends "main.php" %}

{% block body %}
<div class="container 1header d-flex justify-content-between px-4 1bb align-items-center mt-3">

  <div class="1logo bb1 text-center 1me-3 1bb pt-2">
          <a href="https://dov.pp.ua/analytics" class="text-decoration-none text-black">
            <h5>DOV Analytics</h5>
          </a>
  </div>

    <div class="col-auto 1bb">
         
    <button type="button"
                    class="btn btn-outline-dark 1border-0 1border-secondary 1text-primary 1bb
                    text-decoration-none 1fs-5 1bb"
                    data-bs-toggle = "dropdown"
                    1data-bs-target = "dropdown">Menu
            </button>    
    
          <ul class="dropdown-menu">
        <li class="dropdown-item fw-semibold" id="email">{{ projectsList.email }}</li>
            <li><hr class="dropdown-divider"></li>

            <li class="dropdown-item px-0">
                    <buttom type="buttom"
                            class="btn btn-link text-decoration-none text-start text-black col-12"
                            data-bs-toggle = "modal"
                            data-bs-target = "#mod_review">
                            <i class="bi bi-pen ps-1 pe-2"></i>Contact us
                    </buttom>
                
                </li>
                <li class="dropdown-item px-0">
                    <buttom type="buttom"
                            class="btn btn-link text-decoration-none text-start text-black col-12"
                            data-bs-toggle = "modal"
                            data-bs-target = "#mod_about">
                            <i class="bi bi-info-circle ps-1 pe-2"></i>About
                    </buttom>
                </li>
                           
                <li><hr class="dropdown-divider"></li>
                
                <li><a class="dropdown-item" onclick="butEnd()"><i class="bi bi-door-open pe-2"></i>Sign out</a></li>
            </ul>
    </div>
</div>
<hr>
<div class="container mt-5 px-4">

{% for list in projectsList %}
{% if list.key_name %}
  <div class="row 1d-flex 1justify-content-center 1mt-5 1bb py-3 mx-auto"
  style="max-width: 500px;">

      <button type="button"
              class="btn 1btn-outline-dark col-12 1mx-auto fs-5 bg-white"
              onclick="getAnalytics('{{ list.key_name }}')">
              <img src="/projects/{{ list.key_name }}/app/views/img/favicon.ico" width="54px">
              {{ list.name }} <br> 
              <span style="font-size: 14px;"> Today: </span> {{ list.count.total }}
              <span style="font-size: 14px;">Reg:</span> {{ list.count.reg }}
              <span style="font-size: 14px;">Online:</span> {{ list.count.online }} 
              <!-- <br><span class="1fs-6"> Today: {{ list.total }}</span> -->
      </button> 
 
    </div>
{% endif %}

{% if not projectsList.0 %}
  <h5>No projects found ...</h5> 
{% endif %}

{% endfor %}
</div>

<!-- footer -->
<div class="mx-auto fixed-bottom pb-3" style="max-width: 1000px">


    <a class="text-decoration-none text-black" href="https://www.linkedin.com/in/danyshevskyi/" target="blank"> 
    <div class="text-center mt-3" style="font-size: 13px;">Oleksii Danyshevskyi &copy; 2024 
       
    <i class="bi bi-linkedin"></i>
</div>
    </a>
</div>
{% endblock %}

{% block js %}
<script type="text/javascript">
{{ include('js/mod_about.js') }}
</script>
{% endblock %}