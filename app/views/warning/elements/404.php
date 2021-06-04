        <div id="main">
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <div class="error404--content-wrap">
                                    <div class="error404--content mt-16">
                                        <h1 class="color fz-100 fw-bold mb-2">404</h1>
                                        <h2 class="mb-6">La página solicitada <b>({{ page }})</b> no existe.</h2>
                                        <div class="error-buttons">
                                            <a href="{{ host }}inicio/" class="button style-outline">
                                                <span class="button-icon ion-home"></span>
                                                <span class="button-text">Volver al inicio</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", () => {

                setTimeout(() => document.getElementById('myloader-receta').style.display = 'none', 500);

            });
        </script>