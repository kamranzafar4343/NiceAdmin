/**
* Template Name: NiceAdmin
* Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
* Updated: Apr 20 2024 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/

// JavaScript to trigger the file input when image is clicked


(function() {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    if (all) {
      select(el, all).forEach(e => e.addEventListener(type, listener))
    } else {
      select(el, all).addEventListener(type, listener)
    }
  }

  /**
   * Easy on scroll event listener 
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Sidebar toggle
   */
  if (select('.toggle-sidebar-btn')) {
    on('click', '.toggle-sidebar-btn', function(e) {
      select('body').classList.toggle('toggle-sidebar')
    })
  }

  /**
   * Search bar toggle
   */
  if (select('.search-bar-toggle')) {
    on('click', '.search-bar-toggle', function(e) {
      select('.search-bar').classList.toggle('search-bar-show')
    })
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Initiate tooltips
   */
  var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
  var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
  })

  /**
   * Initiate quill editors
   */
  if (select('.quill-editor-default')) {
    new Quill('.quill-editor-default', {
      theme: 'snow'
    });
  }

  if (select('.quill-editor-bubble')) {
    new Quill('.quill-editor-bubble', {
      theme: 'bubble'
    });
  }

  if (select('.quill-editor-full')) {
    new Quill(".quill-editor-full", {
      modules: {
        toolbar: [
          [{
            font: []
          }, {
            size: []
          }],
          ["bold", "italic", "underline", "strike"],
          [{
              color: []
            },
            {
              background: []
            }
          ],
          [{
              script: "super"
            },
            {
              script: "sub"
            }
          ],
          [{
              list: "ordered"
            },
            {
              list: "bullet"
            },
            {
              indent: "-1"
            },
            {
              indent: "+1"
            }
          ],
          ["direction", {
            align: []
          }],
          ["link", "image", "video"],
          ["clean"]
        ]
      },
      theme: "snow"
    });
  }

  /**
   * Initiate TinyMCE Editor
   */

  const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const isSmallScreen = window.matchMedia('(max-width: 1023.5px)').matches;

  tinymce.init({
    selector: 'textarea.tinymce-editor',
    plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion',
    editimage_cors_hosts: ['picsum.photos'],
    menubar: 'file edit view insert format tools table help',
    toolbar: "undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl",
    autosave_ask_before_unload: true,
    autosave_interval: '30s',
    autosave_prefix: '{path}{query}-{id}-',
    autosave_restore_when_empty: false,
    autosave_retention: '2m',
    image_advtab: true,
    link_list: [{
        title: 'My page 1',
        value: 'https://www.tiny.cloud'
      },
      {
        title: 'My page 2',
        value: 'http://www.moxiecode.com'
      }
    ],
    image_list: [{
        title: 'My page 1',
        value: 'https://www.tiny.cloud'
      },
      {
        title: 'My page 2',
        value: 'http://www.moxiecode.com'
      }
    ],
    image_class_list: [{
        title: 'None',
        value: ''
      },
      {
        title: 'Some class',
        value: 'class-name'
      }
    ],
    importcss_append: true,
    file_picker_callback: (callback, value, meta) => {
      /* Provide file and text for the link dialog */
      if (meta.filetype === 'file') {
        callback('https://www.google.com/logos/google.jpg', {
          text: 'My text'
        });
      }

      /* Provide image and alt text for the image dialog */
      if (meta.filetype === 'image') {
        callback('https://www.google.com/logos/google.jpg', {
          alt: 'My alt text'
        });
      }

      /* Provide alternative source and posted for the media dialog */
      if (meta.filetype === 'media') {
        callback('movie.mp4', {
          source2: 'alt.ogg',
          poster: 'https://www.google.com/logos/google.jpg'
        });
      }
    },
    height: 600,
    image_caption: true,
    quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
    noneditable_class: 'mceNonEditable',
    toolbar_mode: 'sliding',
    contextmenu: 'link image table',
    skin: useDarkMode ? 'oxide-dark' : 'oxide',
    content_css: useDarkMode ? 'dark' : 'default',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
  });

  /**
   * Initiate Bootstrap validation check
   */
  var needsValidation = document.querySelectorAll('.needs-validation')

  Array.prototype.slice.call(needsValidation)
    .forEach(function(form) {
      form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })

  /**
   * Initiate Datatables
   */
  const datatables = select('.datatable', true)
  datatables.forEach(datatable => {
    new simpleDatatables.DataTable(datatable, {
      perPageSelect: [5, 10, 15, ["All", -1]],
      columns: [{
          select: 2,
          sortSequence: ["desc", "asc"]
        },
        {
          select: 3,
          sortSequence: ["desc"]
        },
        {
          select: 4,
          cellClass: "green",
          headerClass: "red"
        }
      ]
    });
  })

  /**
   * Autoresize echart charts
   */
  const mainContainer = select('#main');
  if (mainContainer) {
    setTimeout(() => {
      new ResizeObserver(function() {
        select('.echart', true).forEach(getEchart => {
          echarts.getInstanceByDom(getEchart).resize();
        })
      }).observe(mainContainer);
    }, 200);
  }

})()

//email ajax
$(document).ready(function() {
  $('#email').blur(function() {
      var email = $(this).val();

      $.ajax({
          url: 'check_email.php',
          method: 'POST',
          data: {
              email: email
          },
          success: function(response) {
              if (response === 'exists') {
                  $('#email').addClass('is-invalid');
                  $('#emailFeedback').text('Email already exists. Please use another email.');
              } else {
                  $('#email').removeClass('is-invalid');
                  $('#emailFeedback').text('');
              }
          }
      });
  });
});

//box name ajax
$(document).ready(function() {
  $('#box_name').blur(function() {
      var box_name = $(this).val();

      $.ajax({
          url: 'box_validation.php',
          method: 'POST',
          data: {
              box_name: box_name
          },
          success: function(response) {
              if (response === 'exists') {
                  $('#box_name').addClass('is-invalid');
                  $('#boxNameFeedback').text('Box Name already exists');
              } else {
                  $('#box_name').removeClass('is-invalid');
                  $('#boxNameFeedback').text('');
              }
          }
      });
  });
});


window.onload = function() {
  // Get the current date
  const today = new Date();

  // Format the date to YYYY-MM-DD
  const formattedDate = today.toISOString().split('T')[0];

  // Set the value of the date input to the formatted date
  document.getElementById('registration').value = formattedDate;
};
window.onload = function() {
  // Get the current date
  const today = new Date();

  // Format the current date to YYYY-MM-DD for the registration date
  const formattedDate = today.toISOString().split('T')[0];

  // Set the current date as the default value for the registration date input
  document.getElementById('registration').value = formattedDate;

  // Calculate the date one year from today
  const nextYear = new Date(today);
  nextYear.setFullYear(today.getFullYear() + 1);

  // Format the date one year from today to YYYY-MM-DD for the expiry date
  const formattedExpiryDate = nextYear.toISOString().split('T')[0];

  // Set the default value for the expiry date input to one year from today
  document.getElementById('expiry').value = formattedExpiryDate;
};


// JavaScript data and functions remain unchanged
/*const data = {
  "Pakistan": {
      "Punjab": ["Lahore", "Faisalabad", "Rawalpindi", "Multan", "Gujranwala", "Okara", "Pattoki", "Sialkot", "Sargodha", "Bahawalpur", "Jhang", "Sheikhupura"],
      "Sindh": ["Karachi", "Hyderabad", "Sukkur", "Larkana", "Nawabshah", "Mirpur Khas", "Shikarpur", "Jacobabad"],
      "Khyber Pakhtunkhwa": ["Peshawar", "Mardan", "Mingora", "Abbottabad", "Mansehra", "Kohat", "Dera Ismail Khan"],
      "Balochistan": ["Quetta", "Gwadar", "Turbat", "Sibi", "Khuzdar", "Zhob"],
      "Islamabad Capital Territory": ["Islamabad"],
      "Azad Jammu and Kashmir": ["Muzaffarabad", "Mirpur", "Rawalakot"],
      "Gilgit-Baltistan": ["Gilgit", "Skardu", "Hunza"]
  },
  "United States": {
      "California": ["Los Angeles", "San Francisco", "San Diego"],
      "New York": ["New York City", "Buffalo", "Rochester"],
      "Texas": ["Houston", "Austin", "Dallas"]
  },
  "Canada": {
      "Ontario": ["Toronto", "Ottawa", "Mississauga"],
      "Quebec": ["Montreal", "Quebec City"],
      "British Columbia": ["Vancouver", "Victoria"]
  },
  "United Kingdom": {
      "England": ["London", "Manchester", "Liverpool"],
      "Scotland": ["Edinburgh", "Glasgow"],
      "Wales": ["Cardiff", "Swansea"],
      "Northern Ireland": ["Belfast", "Derry"]
  }
  // Add more countries and their states and cities here
};

function populateStatesAndCities() {
  const countrySelect = document.getElementById('country');
  const stateSelect = document.getElementById('state');
  const citySelect = document.getElementById('city');
  const selectedCountry = countrySelect.value;

  stateSelect.innerHTML = '';
  citySelect.innerHTML = '';

  if (data[selectedCountry]) {
      const states = Object.keys(data[selectedCountry]);
      states.forEach(state => {
          const option = document.createElement('option');
          option.value = state;
          option.textContent = state;
          stateSelect.appendChild(option);
      });

      populateCities();
  }
}

function populateCities() {
  const countrySelect = document.getElementById('country');
  const stateSelect = document.getElementById('state');
  const citySelect = document.getElementById('city');
  const selectedCountry = countrySelect.value;
  const selectedState = stateSelect.value;

  citySelect.innerHTML = '';

  if (data[selectedCountry] && data[selectedCountry][selectedState]) {
      const cities = data[selectedCountry][selectedState];
      cities.forEach(city => {
          const option = document.createElement('option');
          option.value = city;
          option.textContent = city;
          citySelect.appendChild(option);
      });
  }
}

window.onload = function() {
  populateStatesAndCities();
};*/




//for updating image -----------------------------------------------------------
document.getElementById('currentImage').addEventListener('click', function () {
  document.getElementById('fileInput').click();
});

// JavaScript to handle file input change and upload the image
document.getElementById('fileInput').addEventListener('change', function (event) {
  var file = event.target.files[0];
  if (file) {
      var formData = new FormData();
      formData.append('image', file);

      // AJAX request to upload the image
      var xhr = new XMLHttpRequest();
      xhr.open('POST', 'upload_image.php', true);
      
      xhr.onload = function () {
          if (xhr.status === 200) {
              // On successful upload, update the image src with the new image path
              document.getElementById('currentImage').src = xhr.responseText;
              alert('Image updated successfully!');
          } else {
              alert('Error updating image.');
          }
      };

      xhr.send(formData);
  }
});
;