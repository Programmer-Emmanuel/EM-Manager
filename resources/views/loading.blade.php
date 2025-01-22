
  <style>
    #loading {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(38, 38, 38, 0.63);
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }

    .spinner {
      border: 8px solid rgb(255, 255, 255);
      border-top: 8px solid rgb(2, 9, 37);
      border-radius: 50%;
      width: 50px;
      height: 50px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }
      100% {
        transform: rotate(360deg);
      }
    }
  </style>

  <div id="loading">
    <div class="spinner"></div>
  </div>

  <script>
    window.addEventListener("load", function () {
      const loadingElement = document.getElementById("loading");
      

      setTimeout(function() {
        loadingElement.style.display = "none";
      }, 200); 
    });
  </script>
