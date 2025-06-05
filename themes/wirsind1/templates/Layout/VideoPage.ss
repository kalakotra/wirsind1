<% if HeaderImage %>
    <section class="pageHeader" style="background-image: url($HeaderImage.URL)">
        <div class="container py-3 py-lg-5">
            <div class="row justify-content-center">
                <div class="col-12 col-md-8  py-3 py-lg-5">
                    <article class="text-center">
                        <h1 class="fw-bold">$Title</h1>
                    </article>
                </div>
            </div>
        </div>
    </section>
<% end_if %>
<main>
    <div class="container py-3 py-lg-5">
        <div class="row justify-content-center">
            <div class="col-12 d-none">
                <h1 class="">$Title</h1>
            </div>
            <div class="col-12 col-md-8 pb-3">
                <article>
                    <div class="content py-3 py-lg-5-">$Content</div>
                    <% if TerminLink %>
                        <div class="py-1">
                            <a href="$TerminLink" class="btn btn-dark rounded-pill px-4">Nächster Termin</a>
                        </div>
                    <% end_if %>
                    <% if TextAfterTerminLink %>
                        <div class="py-3 py-lg-5">$TextAfterTerminLink</div>
                    <% end_if %>
                </article>
            </div>
            <div class="col-12 col-md-4 offset-xl-1 col-xl-3 pb-3">
                <div class="p-3 p-lg-5 shadow text-center text-dark rounded-4">
                    <strong>$WidgetTitle</strong><br />$WidgetText
                    <div class="pt-3">
                        <a href="epu-netzwerk/profil" class="btn btn-dark rounded-pill px-4">Jetzt registrieren</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<% if Video1 || Video2 || Video3 %>
    <section class="bg-light">
        <div class="container py-3 py-lg-5">
            <div class="row justify-content-center">
                <div class="col-12 py-3">
                    <h2 class="text-center">$Video1Title</h2>
                </div>
                <% if Video1 %>
                    <div class="col-12 col-md-4 py-3 text-center">
                        <video controls poster='$Poster1.FocusFill(365,648).URL' width="280" height="497">
                            <source src="$Video1.URL" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <% end_if %>
                <% if Video2 %>
                    <div class="col-12 col-md-4 py-3 text-center">
                        <video controls poster='$Poster2.FocusFill(365,648).URL' width="280" height="497">
                            <source src="$Video2.URL" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <% end_if %>
                <% if Video3 %>
                    <div class="col-12 col-md-4 py-3 text-center">
                        <video controls poster='$Poster3.FocusFill(365,648).URL' width="280" height="497">
                            <source src="$Video3.URL" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                <% end_if %>
            </div>
        </div>
    </section>
<% end_if %>