<div id="{$CarouselID}" class="carousel slide <% if CarouselCustomClass %>$CarouselCustomClass<% end_if %>"  data-bs-ride="carousel">
    <% if CarouselIndicator=1 && CarouselLoop.count>1 %>
        <div class="carousel-indicators">
            <% loop CarouselLoop %>
                <button type="button" data-bs-target="#{$Up.CarouselID}" data-bs-slide-to="$Pos(0)" <% if First %>class="active" aria-current="true"<% end_if %> aria-label="Slide $Pos(1)"></button>
            <% end_loop %>
        </div>
    <% end_if %>
    <div class="carousel-inner">
        <% loop CarouselLoop %>
            <div class="carousel-item <% if First %>active<% end_if %>" <% if SlideTime %>data-bs-interval="$convertedSlideTime"<% end_if %>>
                <% if VideoDesktop %>
                    <video autoplay loop muted playsinline class="fullWidthVideo d-none d-md-block">
                        <source src="$VideoDesktop.URL" type="video/mp4">
                    </video>
                    <video autoplay loop muted playsinline class="fullWidthVideo d-md-none">
                        <source src="$VideoMobile.URL" type="video/mp4">
                    </video>
                <% else %>
                    <a href="<% if Profile %>{$Top.getMyClass('FilterPage').exclude('ClassName', 'FormularPage').First().Link}details/$ProfileID<% else %>$Page.Link<% end_if %>">
                        <picture class="fullWidthImage">
                            <source media="(max-width:768px)" srcset="<% if MobileImage %>$MobileImage.scaleMaxWidth(640).URL<% else %>$Image.FocusFill(640, 500).URL<% end_if %>">
                            <% if First %>
                                <img src="$Image.scaleMaxWidth(1920).URL" alt="$Image.Title" width="1920" height="500" />
                            <% else %>
                                $Image.scaleMaxWidth(1920)
                            <% end_if %>
                        </picture>
                    </a>
                <% end_if %>
            </div>
        <% end_loop %>
    </div>
    <% if CarouselControls=1 %>
        <button class="carousel-control-prev" type="button" data-bs-target="#{$CarouselID}" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#{$CarouselID}" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    <% end_if %>
</div>