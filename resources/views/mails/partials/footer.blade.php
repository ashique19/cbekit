
						</table>
						<!-- // END -->

						<!-- EMAIL FOOTER // -->
						<!--
							The table "emailBody" is the email's container.
							Its width can be set to 100% for a color band
							that spans the width of the page.
						-->
						<table bgcolor="#E1E1E1" border="0" cellpadding="0" cellspacing="0" width="500" id="emailFooter">

							<!-- FOOTER ROW // -->
							<!--
								To move or duplicate any of the design patterns
								in this email, simply move or copy the entire
								MODULE ROW section for each content block.
							-->
							<tr>
								<td align="center" valign="top">
									<!-- CENTERING TABLE // -->
									<table border="0" cellpadding="0" cellspacing="0" width="100%">
										<tr>
											<td align="center" valign="top">
												<!-- FLEXIBLE CONTAINER // -->
												<table border="0" cellpadding="0" cellspacing="0" width="500" class="flexibleContainer">
													<tr>
														<td align="center" valign="top" width="500" class="flexibleContainerCell">
															<table border="0" cellpadding="30" cellspacing="0" width="100%">
																<tr>
																	<td valign="top" bgcolor="#E1E1E1">

																		<div style="font-family:Helvetica,Arial,sans-serif;font-size:13px;color:#828282;text-align:center;line-height:120%;">
																			<div>Copyright &#169; {{date('Y')}} <a href="{{route('home')}}" target="_blank" style="text-decoration:none;color:#828282;"><span style="color:#828282;">{{settings()->application_name}}.</span></a> All&nbsp;rights&nbsp;reserved.</div>
																		</div>

																	</td>
																</tr>
															</table>
														</td>
													</tr>
												</table>
												<!-- // FLEXIBLE CONTAINER -->
											</td>
										</tr>
									</table>
									<!-- // CENTERING TABLE -->
								</td>
							</tr>

						</table>
						<!-- // END -->

					</td>
				</tr>
			</table>
		</center>
	</body>
</html>