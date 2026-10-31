<form $AttributesHTML>
	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	<fieldset>
		<% if $Legend %><legend>$Legend</legend><% end_if %>
		<div class="row">
			<div class="col-12">
				$Fields.dataFieldByName(Subject).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(CompanyName).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(MemberIndustryID).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(FirstName).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(Surname).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(Street).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(PostCode).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(City).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(Region).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(Email).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(Telephone).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(Website).FieldHolder
			</div>

			<div class="w-100"></div>

			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(Image).FieldHolder
				<small>
					<% if $Fields.dataFieldByName(FotoID).Value %>
						Bitte wählen Sie ein anderes Bild aus, wenn Sie mit dem aktuellen Bild nicht zufrieden sind.
					<% else %>
						Bitte lade ein Portraitfoto von dir im Querformat hoch!
					<% end_if %>
				</small>
				<% if $Fields.dataFieldByName(FotoID).Value %>
					<div>
						<div class="rounded-circle overflow-hidden d-inline-block ms-auto me-auto border border-white border-1"><img src="$Fields.dataFieldByName(FotoID).Value" /></div>
					</div>
				<% end_if %>
			</div>

			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(Video).FieldHolder
				<small>
					<% if $Fields.dataFieldByName(VideoPreviewID).Value %>
						Bitte wählen Sie ein anderes Video aus, wenn Sie mit dem aktuellen Video nicht zufrieden sind.
					<% else %>
						Bitte lade ein Video von dir im Hochformat 9:16 hoch: Dauer max. 30 Sekunden, Format .mp4, keine Hintergrundmusik!
					<% end_if %>
				</small>
				<% if $Fields.dataFieldByName(VideoPreviewID).Value %>
					<div>
						<div class="rounded-circle overflow-hidden d-inline-block ms-auto me-auto border border-white border-1">
							<video controls>
								<source src="$Fields.dataFieldByName(VideoPreviewID).Value" type="video/mp4">
								Your browser does not support the video tag.
							</video>
						</div>
					</div>
				<% end_if %>
			</div>

			<div class="w-100"></div>

			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(SocialMedia).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(LinkedIn).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(Instagram).FieldHolder
			</div>

			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(TikTok).FieldHolder
			</div>
			<div class="col-12 col-lg-6 py-2">
				$Fields.dataFieldByName(OtherSocialMedia).FieldHolder
			</div>



			<div class="col-12 py-2">
				$Fields.dataFieldByName(Description).FieldHolder
			</div>
			<div class="col-12 py-2">
				$Fields.dataFieldByName(Text).FieldHolder
			</div>
			<div class="col-12 small py-2">
				$Fields.dataFieldByName(datenschutz).FieldHolder
			</div>
			
		</div>

		<div class="row py-5 justify-content-center">
			<% loop $Actions %>
				<div class="col-auto py-3 text-center">$Field</div>
			<% end_loop %>
		</div>
	</fieldset>
	
	$Fields.dataFieldByName(SecurityID)
	$Fields.dataFieldByName(ID)
</form>