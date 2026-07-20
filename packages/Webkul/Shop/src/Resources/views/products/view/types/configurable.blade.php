@if (Webkul\Product\Helpers\ProductType::hasVariants($product->type))
    {!! view_render_event('bagisto.shop.products.view.configurable-options.before', ['product' => $product]) !!}

    <v-product-configurable-options :errors="errors"></v-product-configurable-options>

    {!! view_render_event('bagisto.shop.products.view.configurable-options.after', ['product' => $product]) !!}

    @push('scripts')
        <script
            type="text/x-template"
            id="v-product-configurable-options-template"
        >
            <div class="w-full max-w-full rounded-xl border border-slate-200 bg-white p-4 shadow-sm max-sm:p-3">
                <input
                    type="hidden"
                    name="selected_configurable_option"
                    id="selected_configurable_option"
                    :value="selectedOptionVariant"
                    ref="selected_configurable_option"
                >

                <p class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-400">
                    @lang('shop::app.products.view.type.configurable.available-options')
                </p>

                <div class="divide-y divide-slate-100">
                    <div
                        class="flex flex-wrap items-center gap-x-4 gap-y-2 py-2.5 transition-opacity first:pt-0 last:pb-0 max-sm:py-2"
                        :class="{'pointer-events-none opacity-40': attribute.disabled}"
                        v-for='(attribute, index) in childAttributes'
                    >
                        <!-- Label + selected value -->
                        <div class="flex w-20 shrink-0 flex-col justify-center max-sm:w-16">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                @{{ attribute.label }}
                            </span>

                            <span
                                class="truncate text-[13px] font-semibold text-slate-900"
                                v-if="attribute.selectedValue"
                            >
                                @{{ attribute.options.find((option) => option.id == attribute.selectedValue)?.label }}
                            </span>
                        </div>

                        <!-- Dropdown Options Container (rendered as selectable chips) -->
                        <template v-if="! attribute.swatch_type || attribute.swatch_type == '' || attribute.swatch_type == 'dropdown'">
                            <div class="flex flex-1 flex-wrap items-center gap-1.5">
                                <template v-for="(option, index) in attribute.options">
                                    <label
                                        v-if="option.id"
                                        class="group relative flex cursor-pointer items-center justify-center gap-1 rounded-md border px-2.5 py-1 text-[13px] font-medium leading-none transition-colors active:scale-95 max-sm:px-2 max-sm:text-xs"
                                        :class="option.id == attribute.selectedValue ? 'border-slate-900 bg-slate-900 text-white' : 'border-slate-200 text-slate-600 hover:border-indigo-500 hover:text-indigo-600'"
                                        :title="option.label"
                                    >
                                        <v-field
                                            type="radio"
                                            :name="'super_attribute[' + attribute.id + ']'"
                                            :value="option.id"
                                            v-model="attribute.selectedValue"
                                            v-slot="{ field }"
                                            rules="required"
                                            :label="attribute.label"
                                            :aria-label="attribute.label"
                                        >
                                            <input
                                                type="radio"
                                                :name="'super_attribute[' + attribute.id + ']'"
                                                :value="option.id"
                                                v-bind="field"
                                                :id="'attribute_' + attribute.id"
                                                class="peer sr-only"
                                                @click="configure(attribute, $event.target.value)"
                                            />
                                        </v-field>

                                        <span>
                                            @{{ option.label }}
                                        </span>
                                    </label>
                                </template>

                                <span
                                    class="text-[13px] text-slate-400 max-sm:text-xs"
                                    v-if="! attribute.options.filter((option) => option.id).length"
                                >
                                    @lang('shop::app.products.view.type.configurable.select-above-options')
                                </span>
                            </div>
                        </template>

                        <!-- Swatch Options Container -->
                        <template v-else>
                            <div class="flex flex-1 flex-wrap items-center gap-2">
                                <template v-for="(option, index) in attribute.options">
                                    <template v-if="option.id">
                                        <!-- Color Swatch Options -->
                                        <label
                                            class="group relative flex h-7 w-7 shrink-0 cursor-pointer items-center justify-center rounded-full transition-transform hover:scale-110 focus:outline-none"
                                            :title="option.label"
                                            v-if="attribute.swatch_type == 'color'"
                                        >
                                            <v-field
                                                type="radio"
                                                :name="'super_attribute[' + attribute.id + ']'"
                                                :value="option.id"
                                                v-slot="{ field }"
                                                rules="required"
                                                :label="attribute.label"
                                                :aria-label="attribute.label"
                                            >
                                                <input
                                                    type="radio"
                                                    :name="'super_attribute[' + attribute.id + ']'"
                                                    :value="option.id"
                                                    v-bind="field"
                                                    :id="'attribute_' + attribute.id"
                                                    :aria-labelledby="'color-choice-' + index + '-label'"
                                                    class="peer sr-only"
                                                    @click="configure(attribute, $event.target.value)"
                                                />
                                            </v-field>

                                            <span
                                                class="pointer-events-none absolute inset-[-3px] rounded-full ring-2 transition-all"
                                                :class="option.id == attribute.selectedValue ? 'ring-slate-900' : 'ring-transparent group-hover:ring-indigo-300'"
                                            ></span>

                                            <span
                                                class="h-full w-full rounded-full border-2 border-white shadow-[0_0_0_1px_rgba(0,0,0,0.1)]"
                                                tabindex="0"
                                                :style="{ 'background-color': option.swatch_value }"
                                            ></span>

                                            <svg
                                                class="pointer-events-none absolute h-3 w-3 text-white drop-shadow-[0_0_1.5px_rgba(0,0,0,0.7)]"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                v-if="option.id == attribute.selectedValue"
                                            >
                                                <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 111.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                            </svg>
                                        </label>

                                        <!-- Image Swatch Options -->
                                        <label
                                            class="group relative flex h-12 w-12 shrink-0 cursor-pointer items-center justify-center overflow-hidden rounded-lg border bg-white transition-all hover:shadow-md"
                                            :class="option.id == attribute.selectedValue ? 'border-slate-900 shadow-sm' : 'border-slate-200 hover:border-indigo-400'"
                                            :title="option.label"
                                            v-if="attribute.swatch_type == 'image'"
                                        >
                                            <v-field
                                                type="radio"
                                                :name="'super_attribute[' + attribute.id + ']'"
                                                v-model="attribute.selectedValue"
                                                :value="option.id"
                                                v-slot="{ field }"
                                                rules="required"
                                                :label="attribute.label"
                                                :aria-label="attribute.label"
                                            >
                                                <input
                                                    type="radio"
                                                    :name="'super_attribute[' + attribute.id + ']'"
                                                    :value="option.id"
                                                    v-bind="field"
                                                    :id="'attribute_' + attribute.id"
                                                    :aria-labelledby="'color-choice-' + index + '-label'"
                                                    class="peer sr-only"
                                                    @click="configure(attribute, $event.target.value)"
                                                />
                                            </v-field>

                                            <img
                                                :src="option.swatch_value"
                                                :title="option.label"
                                                class="h-full w-full object-cover"
                                            />

                                            <span
                                                class="absolute bottom-0 right-0 flex h-4 w-4 items-center justify-center rounded-tl-md bg-slate-900"
                                                v-if="option.id == attribute.selectedValue"
                                            >
                                                <svg class="h-2.5 w-2.5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 111.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" />
                                                </svg>
                                            </span>
                                        </label>

                                        <!-- Text Swatch Options -->
                                        <label
                                            class="group relative flex shrink-0 cursor-pointer items-center justify-center gap-1 rounded-md border px-2.5 py-1 text-[13px] font-medium uppercase leading-none transition-colors active:scale-95 max-sm:px-2 max-sm:text-xs"
                                            :class="option.id == attribute.selectedValue ? 'border-slate-900 bg-slate-900 text-white' : 'border-slate-200 text-slate-600 hover:border-indigo-500 hover:text-indigo-600'"
                                            :title="option.label"
                                            v-if="attribute.swatch_type == 'text'"
                                        >
                                            <v-field
                                                type="radio"
                                                :name="'super_attribute[' + attribute.id + ']'"
                                                :value="option.id"
                                                v-model="attribute.selectedValue"
                                                v-slot="{ field }"
                                                rules="required"
                                                :label="attribute.label"
                                                :aria-label="attribute.label"
                                            >
                                                <input
                                                    type="radio"
                                                    :name="'super_attribute[' + attribute.id + ']'"
                                                    :value="option.id"
                                                    v-bind="field"
                                                    :id="'attribute_' + attribute.id"
                                                    class="peer sr-only"
                                                    :aria-labelledby="'color-choice-' + index + '-label'"
                                                    @click="configure(attribute, $event.target.value)"
                                                />
                                            </v-field>

                                            <span>
                                                @{{ option.label }}
                                            </span>
                                        </label>
                                    </template>
                                </template>

                                <span
                                    class="text-[13px] text-slate-400 max-sm:text-xs"
                                    v-if="! attribute.options.length"
                                >
                                    @lang('shop::app.products.view.type.configurable.select-above-options')
                                </span>
                            </div>
                        </template>

                        <v-error-message
                            :name="'super_attribute[' + attribute.id + ']'"
                            v-slot="{ message }"
                        >
                            <p class="w-full text-xs italic text-red-500">
                                @{{ message }}
                            </p>
                        </v-error-message>
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
            let galleryImages = @json(product_image()->getGalleryImages($product));

            app.component('v-product-configurable-options', {
                template: '#v-product-configurable-options-template',

                props: ['errors'],

                data() {
                    return {
                        config: @json(app('Webkul\Product\Helpers\ConfigurableOption')->getConfigurationConfig($product)),

                        childAttributes: [],

                        possibleOptionVariant: null,

                        selectedOptionVariant: '',

                        galleryImages: [],
                    }
                },

                mounted() {
                    let attributes = JSON.parse(JSON.stringify(this.config)).attributes.slice();

                    let index = attributes.length;

                    while (index--) {
                        let attribute = attributes[index];

                        attribute.options = [];

                        if (index) {
                            attribute.disabled = true;
                        } else {
                            this.fillAttributeOptions(attribute);
                        }

                        attribute = Object.assign(attribute, {
                            childAttributes: this.childAttributes.slice(),
                            prevAttribute: attributes[index - 1],
                            nextAttribute: attributes[index + 1]
                        });

                        this.childAttributes.unshift(attribute);
                    }
                },

                methods: {
                    configure(attribute, optionId) {
                        this.possibleOptionVariant = this.getPossibleOptionVariant(attribute, optionId);

                        if (optionId) {
                            attribute.selectedValue = optionId;
                            
                            if (attribute.nextAttribute) {
                                attribute.nextAttribute.disabled = false;

                                this.clearAttributeSelection(attribute.nextAttribute);

                                this.fillAttributeOptions(attribute.nextAttribute);

                                this.resetChildAttributes(attribute.nextAttribute);
                            } else {
                                this.selectedOptionVariant = this.possibleOptionVariant;
                            }
                        } else {
                            this.clearAttributeSelection(attribute);

                            this.clearAttributeSelection(attribute.nextAttribute);

                            this.resetChildAttributes(attribute);
                        }

                        this.reloadPrice();
                        
                        this.reloadImages();
                    },

                    getPossibleOptionVariant(attribute, optionId) {
                        let matchedOptions = attribute.options.filter(option => option.id == optionId);

                        if (matchedOptions[0]?.allowedProducts) {
                            return matchedOptions[0].allowedProducts[0];
                        }

                        return undefined;
                    },

                    fillAttributeOptions(attribute) {
                        let options = this.config.attributes.find(tempAttribute => tempAttribute.id === attribute.id)?.options;

                        attribute.options = [{
                            'id': '',
                            'label': "@lang('shop::app.products.view.type.configurable.select-options')",
                            'products': []
                        }];

                        if (! options) {
                            return;
                        }

                        let prevAttributeSelectedOption = attribute.prevAttribute?.options.find(option => option.id == attribute.prevAttribute.selectedValue);

                        let index = 1;

                        for (let i = 0; i < options.length; i++) {
                            let allowedProducts = [];

                            if (prevAttributeSelectedOption) {
                                for (let j = 0; j < options[i].products.length; j++) {
                                    if (prevAttributeSelectedOption.allowedProducts && prevAttributeSelectedOption.allowedProducts.includes(options[i].products[j])) {
                                        allowedProducts.push(options[i].products[j]);
                                    }
                                }
                            } else {
                                allowedProducts = options[i].products.slice(0);
                            }

                            if (allowedProducts.length > 0) {
                                options[i].allowedProducts = allowedProducts;

                                attribute.options[index++] = options[i];
                            }
                        }
                    },

                    resetChildAttributes(attribute) {
                        if (! attribute.childAttributes) {
                            return;
                        }

                        attribute.childAttributes.forEach(function (set) {
                            set.selectedValue = null;

                            set.disabled = true;
                        });
                    },

                    clearAttributeSelection (attribute) {
                        if (! attribute) {
                            return;
                        }

                        attribute.selectedValue = null;

                        this.selectedOptionVariant = null;
                    },

                    reloadPrice () {
                        let selectedOptionCount = this.childAttributes.filter(attribute => attribute.selectedValue).length;

                        let finalPrice = document.querySelector('.final-price');

                        let regularPrice = document.querySelector('.regular-price');

                        let configVariant = this.config.variant_prices[this.possibleOptionVariant];

                        if (this.childAttributes.length == selectedOptionCount) {
                            document.querySelector('.price-label').style.display = 'none';

                            if (parseFloat(configVariant.regular.price) > parseFloat(configVariant.final.price)) {
                                regularPrice.style.display = 'block';

                                finalPrice.innerHTML = configVariant.final.formatted_price;

                                regularPrice.innerHTML = configVariant.regular.formatted_price;
                            } else {
                                finalPrice.innerHTML = configVariant.regular.formatted_price;

                                regularPrice.style.display = 'none';

                                regularPrice.innerHTML = '';
                            }

                            this.$emitter.emit('configurable-variant-selected-event',this.possibleOptionVariant);
                        } else {
                            document.querySelector('.price-label').style.display = 'inline-block';

                            const baseRegular = parseFloat(this.config.regular?.price ?? 0);

                            const baseFinal = parseFloat(this.config.final?.price ?? baseRegular);

                            if (baseFinal < baseRegular) {
                                regularPrice.style.display = 'block';

                                regularPrice.innerHTML = this.config.regular.formatted_price;

                                finalPrice.innerHTML = this.config.final.formatted_price;
                            } else {
                                regularPrice.style.display = 'none';

                                regularPrice.innerHTML = '';

                                finalPrice.innerHTML = this.config.regular.formatted_price;
                            }

                            this.$emitter.emit('configurable-variant-selected-event', 0);
                        }
                    },

                    reloadImages () {
                        galleryImages.splice(0, galleryImages.length)

                        if (this.possibleOptionVariant) {
                            this.config.variant_images[this.possibleOptionVariant].forEach(function(image) {
                                galleryImages.push(image);
                            });

                            this.config.variant_videos[this.possibleOptionVariant].forEach(function(video) {
                                galleryImages.push(video);
                            });
                        }

                        this.galleryImages.forEach(function(image) {
                            galleryImages.push(image);
                        });

                        if (galleryImages.length) {
                            this.$parent.$parent.$refs.gallery.media.images =  [...galleryImages];
                        }

                        this.$emitter.emit('configurable-variant-update-images-event', galleryImages);
                    },
                }
            });

        </script>
    @endpush

@endif