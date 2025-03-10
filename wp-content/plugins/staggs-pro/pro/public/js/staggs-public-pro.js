var staggsBaseTextures = {};
var staggsBaseColors = {};

jQuery(document).ready(function($) {
		
	$(document).on('change', '.option-group select', function() {
		var stepId = $(this).parents('.option-group').data('step');

		if ( $(this).parents('.option-group').data('model-type') ) {
			if ( $(this).parents('.option-group').data('model-type') === 'material' ) {
				var names = [];
				if ($(this).parents('.option-group').data('model')) {
					names = $(this).parents('.option-group').data('model').split(/[,][ ]+/);
				}

				if ( $(this).find(':selected').data('preview-urls') ) {
					var texture = $(this).find(':selected').data('preview-urls').replace('0|','');
					var type    = $(this).parents('.option-group').data('model-material');

					for (var n = 0; n < names.length; n++) {
						staggsSetTexture(names[n], type, texture);
					}
				} else if ( $(this).find(':selected').data('color') ) {
					var color = $(this).find(':selected').data('color');

					for (var n = 0; n < names.length; n++) {
						staggsSetMaterialColor(names[n], color, $(this));
					}
				}
			} else if ( $(this).parents('.option-group').data('model-type') === 'variant' ) {
				if ( $(this).parents('.option-group').data('model') ) {
					var variantName = $(this).parents('.option-group').data('model');
					var variant = $(this).find(':selected').val();
					
					if ( variant ) {
						modelViewer[variantName] = variant === 'default' ? null : variant;
					}
				}
			} else if ( $(this).parents('.option-group').data('model-type') === 'node' ) {
				if ( $(this).find(':selected').data('nodes') ) {
					for (var cn = 0; cn < childNodes[stepId].length; cn++){
						if ( childNodes[stepId][cn].includes(':hidden') ) {
							hiddenNodes = removeItem(hiddenNodes, childNodes[stepId][cn]);
						} else {
							visibleNodes = removeItem(visibleNodes, childNodes[stepId][cn]);
						}
					}

					var nodes = $(this).find(':selected').data('nodes').split(/[,][ ]+/);
					for (var n = 0; n < nodes.length; n++){
						if ( nodes[n].includes(':hidden') ) {
							if ( hiddenNodes.indexOf(nodes[n]) === -1 ){
								hiddenNodes.push(nodes[n]);
							}
						} else {
							if ( visibleNodes.indexOf(nodes[n]) === -1 ){
								visibleNodes.push(nodes[n]);
							}
						}
					}

					staggsUpdateNodes();
				}
			}

			if ($(this).parents('.option-group').data('model')) {
				var names = $(this).parents('.option-group').data('model').split(/[,][ ]+/);
				var selected = $(this).find(':selected').length;
				
				staggsSetExtensionValues( $(this).parents('.option-group'), names, selected );
			}

			for (var ch = 0; ch < childHotspots[stepId].length; ch++){
				visibleHotspots = removeItem(visibleHotspots, childHotspots[stepId][ch]);
			}

			if ( $(this).find(':selected').data('hotspots') ) {
				var hotspots = $(this).find(':selected').data('hotspots').split(/[,][ ]+/);
				for (var h = 0; h < hotspots.length; h++){
					if ( visibleHotspots.indexOf(hotspots[h]) === -1 ){
						visibleHotspots.push(hotspots[h]);
					}
				}
			}
		}

		staggsUpdateHotspots();

		updateViewerCameraSettings(this);
	});

	$(document).on('change', '.option-group input', function() {
		var stepId = $(this).parents('.option-group').data('step');

		if ( $(this).parents('.option-group').data('model-type') ) {
			if ( $(this).parents('.option-group').data('model-type') === 'material' ) {
				var names = [];
				if ($(this).parents('.option-group').data('model')) {
					names = $(this).parents('.option-group').data('model').split(/[,][ ]+/);
				}

				if ( $(this).data('preview-urls') ) {
					var texture = $(this).data('preview-urls').replace('0|','');
					var type    = $(this).parents('.option-group').data('model-material');

					if ( ! $(this).is(':checked') ) {
						if ( $(this).parents('.option-group').find('input:checked').length ) {
							texture = $(this).parents('.option-group').find('input:checked').data('preview-urls').replace('0|','');
						} else {
							texture = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=';
						}
					}

					for (var n = 0; n < names.length; n++) {
						staggsSetTexture(names[n], type, texture);
					}
				} else if ( $(this).data('color') ) {
					var color = $(this).data('color');

					if ( ! $(this).is(':checked') ) {
						if ( $(this).parents('.option-group').find('input:checked').length ) {
							color = $(this).parents('.option-group').find('input:checked').data('color');
						} else {
							color = '';
						}
					}

					for (var n = 0; n < names.length; n++) {
						staggsSetMaterialColor(names[n], color, $(this));
					}
				}
			} else if ( $(this).parents('.option-group').data('model-type') === 'variant' ) {
				if ( $(this).parents('.option-group').data('model') ) {
					var variantName = $(this).parents('.option-group').data('model');
					var variant = $(this).val();

					if ( $(this).is(':checked') ) {
						modelViewer[variantName] = variant;
					} else {
						modelViewer[variantName] = null; // Resetting.
					}
				}
			} else if ( $(this).parents('.option-group').data('model-type') === 'node' ) {
				if ( $(this).data('nodes') ) {
					for (var cn = 0; cn < childNodes[stepId].length; cn++){
						if ( childNodes[stepId][cn].includes(':hidden') ) {
							hiddenNodes = removeItem(hiddenNodes, childNodes[stepId][cn]);
						} else {
							visibleNodes = removeItem(visibleNodes, childNodes[stepId][cn]);
						}
					}

					$(this).parents('.option-group-options').find('input').each(function(index,input) {
						if ( $(input).is(':checked') ) {
							if ( $(input).data('nodes') ) {
								var nodes = $(input).data('nodes').split(/[,][ ]+/);
								for (var n = 0; n < nodes.length; n++){
									if ( nodes[n].includes(':hidden') ) {
										if ( hiddenNodes.indexOf(nodes[n]) === -1 ){
											hiddenNodes.push(nodes[n]);
										}
									} else {
										if ( visibleNodes.indexOf(nodes[n]) === -1 ){
											visibleNodes.push(nodes[n]);
										}
									}
								}
							}
						}
					});
					
					staggsUpdateNodes();
				}
			}
		}

		if ($(this).parents('.option-group').data('model')) {
			var names = $(this).parents('.option-group').data('model').split(/[,][ ]+/);
			var selected = $(this).is(':checked');
			
			staggsSetExtensionValues( $(this).parents('.option-group'), names, selected );
		}

		for (var ch = 0; ch < childHotspots[stepId].length; ch++){
			visibleHotspots = removeItem(visibleHotspots, childHotspots[stepId][ch]);
		}

		if ( $(this).data('hotspots') ) {
			$(this).parents('.option-group-options').find('input').each(function(index,input) {
				if ( $(input).is(':checked') ) {
					var hotspots = $(input).data('hotspots').split(/[,][ ]+/);
					for (var h = 0; h < hotspots.length; h++){
						if ( visibleHotspots.indexOf(hotspots[h]) === -1 ){
							visibleHotspots.push(hotspots[h]);
						}
					}
				}
			});
		}
		
		staggsUpdateHotspots();

		updateViewerCameraSettings(this);
	});

	$(document).on('modelOptionsGroupRemoved', function(e, data) {
		if ( 'node' === data.modelType ) {
			staggsUpdateNodes();
		}

		if ( data.model ) {
			if ( data.channel ) {
				staggsSetTexture( data.model, data.channel, '' );
			}

			if ( data.color ) {
				staggsSetMaterialColor( data.model, '', data.input );
			}
		}
	});

	$(document).on('modelMaterialChanged', function(e, data) {
		if ( ! data.model || ! data.channel || ! data.texture ) {
			return;
		}
		staggsSetTexture( data.model, data.channel, data.texture );
	});

	$(document).on('modelMaterialColorChanged', function(e, data) {
		if ( ! data.model || ! data.color ) {
			return;
		}
		staggsSetMaterialColor( data.model, data.color, data.input );
	});

	$(document).on("click", ".staggs-product-view model-viewer .hotspot", function(e) {
		e.preventDefault();
		$(this).toggleClass("active");
	});

	$(document).on('generateNewQRCode', function(e, data) {
		if ( ! data.url ) {
			return;
		}
		$('#staggs-qr-popup').addClass('shown');
		$('body').addClass('panel-shown');
		staggsGenerateQRCode(data.url);
	});
});

function staggsSetExtensionValues( $optionGroup, names, selected ) {
	if ( $optionGroup.data('metalness') ) {
		var metalFactor = '';
		if ( selected ){
			metalFactor = $optionGroup.data('metalness');
		}
		for (var n = 0; n < names.length; n++) {
			staggsSetMaterialMetalness(names[n], metalFactor);
		}
	}

	if ( $optionGroup.data('roughness') ) {
		var roughnessFactor = '';
		if ( selected ){
			roughnessFactor = $optionGroup.data('roughness');
		}
		for (var n = 0; n < names.length; n++) {
			staggsSetMaterialRoughness(names[n], roughnessFactor);
		}
	}

	if ( $optionGroup.data('model-ior') ) {
		var iorFactor = ''; 
		if ( selected ){
			iorFactor = $optionGroup.data('model-ior');
		}
		for (var n = 0; n < names.length; n++) {
			staggsSetMaterialIor(names[n], iorFactor);
		}
	}

	if ( $optionGroup.data('model-clearcoat') ) {
		var clearcoatFactor = '';
		if ( selected ){
			clearcoatFactor = $optionGroup.data('model-clearcoat');
		}
		for (var n = 0; n < names.length; n++) {
			staggsSetClearcoat(names[n], clearcoatFactor);
		}
	}

	if ( $optionGroup.data('model-transmision') ) {
		var transmisionFactor = '';
		if ( selected ){
			transmisionFactor = $optionGroup.data('model-transmision');
		}
		for (var n = 0; n < names.length; n++) {
			staggsSetTransmission(names[n], transmisionFactor);
		}
	}

	if ( $optionGroup.data('model-thickness') ) {
		var thicknessFactor = '';
		if ( selected ){
			thicknessFactor = $optionGroup.data('model-thickness');
		}
		for (var n = 0; n < names.length; n++) {
			staggsSetThickness(names[n], thicknessFactor);
		}
	}

	if ( $optionGroup.data('model-attn-distance') ) {
		var attenuationFactor = '';
		if ( selected ){
			attenuationFactor = $optionGroup.data('model-attn-distance');
		}
		for (var n = 0; n < names.length; n++) {
			staggsSetAttenuationDistance(names[n], attenuationFactor);
		}
	}

	if ( $optionGroup.data('model-attn-color') ) {
		var attenuationColor = '';
		if ( selected ){
			attenuationColor = $optionGroup.data('model-attn-color');
		}
		for (var n = 0; n < names.length; n++) {
			staggsSetAttenuationColor(names[n], attenuationColor);
		}
	}

	if ( $optionGroup.data('model-sheen') ) {
		var sheenColor = '';
		if ( selected ){
			sheenColor = $optionGroup.data('model-sheen');
		}
		for (var n = 0; n < names.length; n++) {
			staggsSetSheenColor(names[n], sheenColor);
		}
	}
	
	if ( $optionGroup.data('model-sheen-roughness') ) {
		var sheenFactor = '';
		if ( selected ){ 
			sheenFactor = $optionGroup.data('model-sheen-roughness');
		}
		for (var n = 0; n < names.length; n++) {
			staggsSetSheenRoughness(names[n], sheenFactor);
		}
	}

	if ( $optionGroup.data('model-specular') ) {
		var specularFactor = '';
		if ( selected ){ 
			specularFactor = $optionGroup.data('model-specular');
		}
		for (var n = 0; n < names.length; n++) {
			staggsSetSpecularFactor(names[n], specularFactor);
		}
	}

	if ( $optionGroup.data('model-specular-color') ) {
		var specularColor = '';
		if ( selected ){ 
			specularColor = $optionGroup.data('model-specular-color');
		}
		for (var n = 0; n < names.length; n++) {
			staggsSetSpecularColor(names[n], specularColor);
		}
	}
}

function staggsGenerateQRCode(newUrl = '') {
	var bgColor = jQuery('#staggs-qr-popup #staggs-qr-code').data('color');
	var textColor = jQuery('#staggs-qr-popup #staggs-qr-code').data('background');
	var url = jQuery('#staggs-qr-code').data('url');
	if ( '' !== newUrl ) {
		url = newUrl;
	}
	// Clear contents.
	jQuery('#staggs-qr-popup #staggs-qr-code').html('');
	// Add QR code
	new QRCode( jQuery('#staggs-qr-code').get(0), {
		correctLevel: QRCode.CorrectLevel.L,
		text: url,
		colorLight: bgColor,
		colorDark: textColor
	});
}

async function staggsSetTexture(name, channel, textureUrl) {
	if ( textureUrl ) {
		var texture = await modelViewer.createTexture(textureUrl);
		// var sampler = texture.sampler;
	} else {
		var texture = false;
	}

	var material = modelViewer.model.getMaterialByName(name);
	if (material) {
		await material.ensureLoaded();

		if ( ! texture ) {
			if ( name in staggsBaseTextures ) {
				texture = staggsBaseTextures[name];
			}
		}

		if (channel.includes("base") || channel.includes("metallic")) {
			if ( "base" == channel ) {
				channel = "baseColorTexture";
			} else {
				channel = "metallicRoughnessTexture";
			}

			if (material != null ) {
				if ( material.pbrMetallicRoughness[channel] ) {
					material.pbrMetallicRoughness[channel].setTexture(texture);
				}
			}
		} else {
			channel = channel + "Texture"; // e.g. occlusionTexture.

			if ( material != null ) {
				if ( material[channel] ) {
					material[channel].setTexture(texture);
				}
			}
		}
	}
}

async function staggsSetMaterialColor(name, color, input = false) {
	var material = modelViewer.model.getMaterialByName(name);

	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();

		if ( ! name in staggsBaseColors ) {
			staggsBaseColors[name] = material.pbrMetallicRoughness.baseColorFactor;
		}

		if (material != null) {
			material.pbrMetallicRoughness.setBaseColorFactor(color);
		}

		if ( input ) {
			if ( jQuery(input).parents('.option-group').data('model-attn-color') ) {
				staggsSetAttenuationColor(name, color);
			}
			
			if ( jQuery(input).parents('.option-group').data('model-sheen-color') ) {
				staggsSetSheenColor(name, color);
			}

			if ( jQuery(input).parents('.option-group').data('model-specular-color') ) {
				staggsSetSpecularColor(name, color);
			}
		}
	}
}

async function staggsSetMaterialRoughness(name, factor) {
	var material = modelViewer.model.getMaterialByName(name);
	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();
		if (material != null) {
			material.pbrMetallicRoughness.setRoughnessFactor(factor);
		}
	}
}

async function staggsSetMaterialMetalness(name, factor) {
	var material = modelViewer.model.getMaterialByName(name);

	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();
		if (material != null) {
			material.pbrMetallicRoughness.setMetallicFactor(factor);
		}
	}
}

async function staggsSetMaterialIor(name, factor) {
	var material = modelViewer.model.getMaterialByName(name);
	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();
		if (material != null) {
			material.setIor(factor);
		}
	}
}

async function staggsSetClearcoat(name, factor) {
	var material = modelViewer.model.getMaterialByName(name);
	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();
		if (material != null) {
			material.setClearcoatFactor(factor);
		}
	}
}

async function staggsSetSheenColor(name, color) {
	var material = modelViewer.model.getMaterialByName(name);
	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();
		if (material != null) {
			material.setSheenColorFactor(color);
		}
	}
}

async function staggsSetSheenRoughness(name, factor) {
	var material = modelViewer.model.getMaterialByName(name);
	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();
		if (material != null) {
			material.setSheenRoughnessFactor(factor);
		}
	}
}

async function staggsSetTransmission(name, factor) {
	var material = modelViewer.model.getMaterialByName(name);
	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();
		if (material != null) {
			material.setTransmissionFactor(factor);
		}
	}
}

async function staggsSetThickness(name, factor) {
	var material = modelViewer.model.getMaterialByName(name);
	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();
		if (material != null) {
			material.setThicknessFactor(factor);
		}
	}
}

async function staggsSetAttenuationDistance(name, factor) {
	var material = modelViewer.model.getMaterialByName(name);
	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();
		if (material != null) {
			material.setAttenuationDistance(factor);
		}
	}
}

async function staggsSetAttenuationColor(name, color) {
	var material = modelViewer.model.getMaterialByName(name);
	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();
		if (material != null) {
			material.setAttenuationColor(color);
		}
	}
}

async function staggsSetSpecularFactor(name, factor) {
	var material = modelViewer.model.getMaterialByName(name);
	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();
		if (material != null) {
			material.setSpecularFactor(factor);
		}
	}
}

async function staggsSetSpecularColor(name, color) {
	var material = modelViewer.model.getMaterialByName(name);
	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();
		if (material != null) {
			material.setSpecularColorFactor(color);
		}
	}
}

function collectNodes( $field ) {
	if ( $field.find(":selected").length ) {
		if ( $field.find(":selected").data("nodes") ) {
			var nodes = $field.find(":selected").data("nodes").split(/[,][ ]+/);
			for (var n = 0; n < nodes.length; n++){
				if ( nodes[n].includes(':hidden') ) {
					if ( allGroups.length ) {
						var groupIndex = allGroupNames.indexOf(nodes[n]);
						if ( allGroups[groupIndex] ) {
							allGroups[groupIndex].traverse((child) => {
								if ( child.type ) {
									if ( child.type == "Mesh" ) {
										if ( hiddenNodes.indexOf(child.name) === -1 ){
											hiddenNodes.push(child.name);
										}
									}
								}
							});
						} else {
							if ( hiddenNodes.indexOf(nodes[n]) === -1 ){
								hiddenNodes.push(nodes[n]);
							}
						}
					} else {
						if ( hiddenNodes.indexOf(nodes[n]) === -1 ){
							hiddenNodes.push(nodes[n]);
						}
					}
				} else {
					if ( allGroups.length ) {
						var groupIndex = allGroupNames.indexOf(nodes[n]);
						if ( allGroups[groupIndex] ) {
							allGroups[groupIndex].traverse((child) => {
								if ( child.type ) {
									if ( child.type == "Mesh" ) {
										if ( visibleNodes.indexOf(child.name) === -1 ){
											visibleNodes.push(child.name);
										}
									}
								}
							});
						} else {
							if ( visibleNodes.indexOf(nodes[n]) === -1 ){
								visibleNodes.push(nodes[n]);
							}
						}
					} else {
						if ( visibleNodes.indexOf(nodes[n]) === -1 ){
							visibleNodes.push(nodes[n]);
						}
					}
				}
			}
		}
	} else if ( $field.is(":checked") ) {
		if ( $field.data("nodes") ) {
			$field.parents(".option-group-options").find("input").each(function(index,input) {
				if ( jQuery(input).is(":checked") ) {
					if ( jQuery(input).data("nodes") ) {
						var nodes = jQuery(input).data("nodes").split(/[,][ ]+/);
						for (var n = 0; n < nodes.length; n++){
							if ( nodes[n].includes(':hidden') ) {
								if ( allGroups.length ) {
									var groupIndex = allGroupNames.indexOf(nodes[n]);
									if ( allGroups[groupIndex] ) {
										allGroups[groupIndex].traverse((child) => {
											if ( child.type ) {
												if ( child.type == "Mesh" ) {
													if ( hiddenNodes.indexOf(child.name) === -1 ){
														hiddenNodes.push(child.name);
													}
												}
											} 
										});
									} else {
										if ( hiddenNodes.indexOf(nodes[n]) === -1 ){
											hiddenNodes.push(nodes[n]);
										}
									}
								} else {
									if ( hiddenNodes.indexOf(nodes[n]) === -1 ){
										hiddenNodes.push(nodes[n]);
									}
								}
							} else {
								if ( allGroups.length ) {
									var groupIndex = allGroupNames.indexOf(nodes[n]);
									if ( allGroups[groupIndex] ) {
										allGroups[groupIndex].traverse((child) => {
											if ( child.type ) {
												if ( child.type == "Mesh" ) {
													if ( visibleNodes.indexOf(child.name) === -1 ){
														visibleNodes.push(child.name);
													}
												}
											}
										});
									} else {
										if ( visibleNodes.indexOf(nodes[n]) === -1 ){
											visibleNodes.push(nodes[n]);
										}
									}
								} else {
									if ( visibleNodes.indexOf(nodes[n]) === -1 ){
										visibleNodes.push(nodes[n]);
									}
								}
							}
						}
					}
				} 
			});
		}
	}
}

function staggsUpdateNodes() {
	visibleNodes = structuredClone( baseNodes );

	Object.keys(childNodes).forEach((groupId, index) => {
		if ( jQuery(".option-group[data-step=" + groupId + "]").length ) {
			if ( jQuery(".option-group[data-step=" + groupId + "] select").length ) {
				jQuery(".option-group[data-step=" + groupId + "] select").each(function(index,select) {
					collectNodes( jQuery(select) );
				});
			} else if ( jQuery(".option-group[data-step=" + groupId + "] input:checked").length ) {
				jQuery(".option-group[data-step=" + groupId + "] input:checked").each(function(index,input) {
					collectNodes( jQuery(input) );
				});
			}
		}
	});

	if (allObjects) {
		for ( var i = 0; i < allObjects.length; i++ ) {
			if ( visibleNodes.indexOf( allObjects[i].name ) === -1 || hiddenNodes.indexOf( allObjects[i].name + ':hidden' ) !== -1 ) {
				allObjects[i].visible = false;
			} else {
				allObjects[i].visible = true;
			}
		}
	}

	if (modelViewer[sceneSym]) {
		modelViewer[sceneSym].isDirty = true;

		modelViewer[sceneSym].updateShadow();
		modelViewer[sceneSym].queueRender();
	}
}

function staggsUpdateHotspots() {
	jQuery(".staggs-product-view model-viewer").find(".hotspot").remove();

	for (var bh = 0; bh < baseHotspots.length; bh++){
		var hotspotData = modelHotspotData.find(data => data.id == baseHotspots[bh]);
		if ( hotspotData ) {
			jQuery(".staggs-product-view model-viewer").append(
				"<button class=\'hotspot\' slot=\'hotspot-" + hotspotData.id + "\' data-position=\'" + hotspotData.position + "\' data-normal=\'" + hotspotData.normal + "\'><div class=\'hotspot-toggle\'>" + plusicon + minusicon + "</div><div class=\'hotspot-content\'>" + hotspotData.content + "</div></button>"
			);
		}
	}

	for (var vh = 0; vh < visibleHotspots.length; vh++){
		var key = visibleHotspots[vh];
		if ( ! baseHotspots.includes( key ) ) {
			var hotspotData = modelHotspotData.find(data => data.id == visibleHotspots[vh]);
			if ( hotspotData ) {
				jQuery(".staggs-product-view model-viewer").append(
					"<button class=\'hotspot\' slot=\'hotspot-" + hotspotData.id + "\' data-position=\'" + hotspotData.position + "\' data-normal=\'" + hotspotData.normal + "\'><div class=\'hotspot-toggle\'>" + plusicon + minusicon + "</div><div class=\'hotspot-content\'>" + hotspotData.content + "</div></button>"
				);
			}
		}
	}
}

function removeItem(arr, value) {
	var index = arr.indexOf(value);
	if (index > -1) {
		arr.splice(index, 1);
	}
	return arr;
}

async function staggsSetMaterialText(name, text) {
	var material = modelViewer.model.getMaterialByName(name);

	if (material) {
		// Make sure material is loaded.
		await material.ensureLoaded();

		if (material != null) {
			const {baseColorTexture} = material.pbrMetallicRoughness;

			baseColorTexture.setTexture(staggsGetCanvasTexture());
			// material.pbrMetallicRoughness.setTexture(staggsGetCanvasTexture());
		}
	}
}

var canvasTexture = null;
function staggsGetCanvasTexture() {
	if(canvasTexture) return canvasTexture;
	canvasTexture = modelViewer.createCanvasTexture();
	var sampler = canvasTexture.sampler;
	sampler.setWrapS(33071);
	sampler.setWrapT(33071);
	sampler.setRotation(1.13);
	const canvas = canvasTexture.source.element;
	canvas.width = 900;
	canvas.height = 900;
	const ctx = canvas.getContext("2d");
	ctx.font = "90px sans-serif";
	ctx.fillStyle = "#000";
	ctx.fillText("LOGO", 200, 900);
	canvasTexture.source.update();
	return canvasTexture;
}

function createCanvasImageTexture(name, channel, textureUrl) {
	// if(canvasTexture) return canvasTexture;
	var canvasTexture = modelViewer.createCanvasTexture();
	const canvas = canvasTexture.source.element;
	const ctx = canvas.getContext("2d");
	canvas.width = 1200;
	canvas.height = 1200;
	const img = new Image();
	img.onload = function() {
		ctx.drawImage(img, 0, 0, img.width, img.height);
		canvasTexture.source.update();	
	}
	img.src = textureUrl;
	canvasTexture.source.update();
	return canvasTexture;
}

function updateViewerCameraSettings(option) {
	if ( jQuery(modelViewer).hasClass("init") ) {
		return;
	}

	if ( jQuery(option).parents(".option-group").data("model-target") ) {
		jQuery(modelViewer).attr("camera-target", jQuery(option).parents(".option-group").data("model-target") );
		jQuery(modelViewer).attr("camera-orbit", jQuery(option).parents(".option-group").data("model-orbit") );
		jQuery(modelViewer).attr("field-of-view", jQuery(option).parents(".option-group").data("model-view") );
		jQuery(modelViewer).addClass("view-changed");
	} else if ( jQuery(modelViewer).hasClass("view-changed") ) {
		jQuery(modelViewer).attr("camera-target", "");
		jQuery(modelViewer).attr("camera-orbit", "");
		jQuery(modelViewer).attr("field-of-view", "");
		jQuery(modelViewer).removeClass("view-changed");
	}
	
	playViewerOptionAnimation(option);
}

async function playViewerOptionAnimation(option) {
	if ( jQuery(option).data("animation") ) {
		// jQuery(option).parents(".option-group").find("input:not(:checked)").prop("disabled",true); // prevent spammy
		// jQuery(".staggs-cart-form-button .single_add_to_cart_button").prop("disabled", true);
		jQuery(modelViewer).attr("animation-name", jQuery(option).data("animation"));

		await jQuery(modelViewer).get(0).updateComplete;
		jQuery(modelViewer).get(0).play({repetitions: 1});
	} else {
		jQuery(modelViewer).attr("animation-name", "");
		jQuery(modelViewer).get(0).pause();
	}
}