<x-shop::layouts>
    @php
    $services = [

        'smart-lighting-systems' => [
            'title'  => 'Smart Lighting Systems',
            'icon'   => 'fas fa-lightbulb',
            'hero'   => 'service/service_1_1.jpg',
            'sections' => [
                [
                    'heading' => 'Controlling Lighting Via Wifi Devices',
                    'text'    => 'How do smart lights work? Smart lights have a chip inside them so that they can communicate with other devices wirelessly. Every light can connect to an app, smart home assistant, or other smart accessory, so you can automate your lights, change their color, or control them remotely.',
                ],
                [
                    'heading'    => 'Ring Smart Lighting System',
                    'subheading' => 'Outside Lighting',
                    'text'       => 'The Ring Smart Lighting System lets you create a network of motion-based security lights for the outside of your home.',
                ],
            ],
            'videos' => [
                ['type' => 'reel', 'id' => '1635133803706127', 'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '1073055697624228', 'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '488604840875876',  'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '931350905509884',  'w' => 267, 'h' => 476],
            ],
            'ctas' => [
                ['text' => 'Make an Enquiry', 'href' => 'contact', 'style' => 'th-btn'],
            ],
        ],

        'smart-door-lock-systems' => [
            'title'  => 'Smart Door Lock Systems',
            'icon'   => 'fas fa-lock',
            'hero'   => 'service/service_1_2.jpg',
            'sections' => [
                [
                    'heading'    => 'How it all works',
                    'text'       => "Mazzy Automation's Smart Door Lock Systems combine a range of convenient and secure features, such as:",
                    'bullets'    => [
                        'Biometric authentication: fingerprint, facial recognition, or iris scanning',
                        'Keyless entry: PIN codes, RFID cards, or mobile app access',
                        'Remote monitoring: receive notifications and control the lock via a mobile app',
                        'Voice assistant integration: compatibility with popular voice assistants like Alexa or Google Assistant',
                        'Advanced security features: anti-pick pins, anti-drill plates, and alarm systems',
                    ],
                    'text_after' => 'These smart door locks can enhance home security, provide ease of use, and offer peace of mind for homeowners.',
                ],
            ],
            'videos' => [
                ['type' => 'reel', 'id' => '978995680663236',  'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '1635133803706127', 'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '978995680663236',  'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '543134681659504',  'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '986519252754449',  'w' => 476, 'h' => 476],
            ],
            'ctas' => [
                ['text' => 'Make an Enquiry', 'href' => 'contact', 'style' => 'th-btn'],
            ],
        ],

        'smart-curtain-systems' => [
            'title'  => 'Smart Curtain Systems',
            'icon'   => 'fas fa-window-maximize',
            'hero'   => 'service/service_1_3.jpg',
            'sections' => [
                ['heading' => 'How it all works'],
                [
                    'heading' => 'Smart Curtain System',
                    'text'    => 'A smart curtain works like magic thanks to their motorized system. They have a special motor that helps them open and close automatically. You can control the curtains with a remote control or a phone app, and you can even use the internet to do it from anywhere.',
                ],
                [
                    'heading' => 'Silent Operation',
                    'text'    => 'Super quiet smart automatic curtain motor track system, responsive and quiet operate, no worry about the noises. Motorized curtain tracks are perfect for hard to reach or heavy curtains. Need to plug in, please make sure there is a port near the motorized curtain rod.',
                ],
            ],
            'videos' => [
                ['type' => 'reel',  'id' => '1614870425777385', 'w' => 267, 'h' => 476],
                ['type' => 'video', 'id' => '501806799259899',  'w' => 560, 'h' => 315],
                ['type' => 'reel',  'id' => '683643343091594',  'w' => 476, 'h' => 476],
                ['type' => 'video', 'id' => '1008538801074723', 'w' => 380, 'h' => 476],
            ],
            'ctas' => [
                ['text' => 'Make an Enquiry', 'href' => 'contact', 'style' => 'th-btn'],
            ],
        ],

        'smart-hotel-solutions' => [
            'title'  => 'Smart Hotel Solutions',
            'icon'   => 'fas fa-hotel',
            'hero'   => 'service/service_1_1.jpg',
            'sections' => [
                [
                    'text' => "From check in to check out, a hotel guest must only ever experience the very highest levels of comfort, service, and convenience. To make this a reality, Mazzy Automations has developed a range of automation solutions designed specifically for hotels. With an automated hotel, the working efficiency can also be improved so that resources can be redistributed towards a hotel's primary focus, guest satisfaction.",
                ],
                [
                    'heading' => 'Guest Rooms',
                    'text'    => 'Guest rooms RF cardholders -including concierges, guests, and cleaners- can be identified with different permissions when the card is inserted. Then the devices and appliances are automatically turned on and enter stand-by mode when the card is pulled away.',
                ],
                [
                    'heading' => 'Welcome Mode',
                    'text'    => 'With the Mazzy Automation hotel automation system, the receptionist can select the "Check-in" Mode for guests. The hotel automation system will automatically turn on the air conditioner and keep a comfortable temperature before the guest enters the room. And the AC will enter into "Stand-by" Mode after the guest leaves the room to save energy.',
                ],
            ],
            'videos' => [],
            'ctas' => [
                ['text' => 'Make an Enquiry', 'href' => 'contact', 'style' => 'th-btn'],
            ],
        ],

        'smart-gate-systems' => [
            'title'  => 'Smart Gate Systems',
            'icon'   => 'fas fa-door-open',
            'hero'   => 'service/service_1_2.jpg',
            'sections' => [
                [
                    'text' => "Mazzy Automations' Smart Gate Systems offer a convenient, secure, and technologically advanced solution for controlling access to your property.",
                ],
                [
                    'heading' => 'Key Features',
                    'bullets' => [
                        'Automated gate opening: motorized gates can be opened and closed with the touch of a button',
                        'Secure access control: grant access to authorized individuals using PIN codes, RFID cards, or biometric authentication',
                        'Remote monitoring and control: monitor and control your gate from anywhere using a mobile app',
                        'Vehicle detection: sensors detect approaching vehicles and automatically open the gate',
                        'Pedestrian access: separate pedestrian gates or access points can be integrated into the system',
                    ],
                ],
                [
                    'heading' => 'Smart Features',
                    'bullets' => [
                        'Wi-Fi and GSM connectivity: connect your gate system to the internet for remote monitoring and control',
                        'Mobile app integration: receive notifications and control your gate using a mobile app',
                        'Voice assistant integration: compatible with popular voice assistants like Alexa or Google Assistant',
                        'Solar power option: environmentally friendly and cost-effective solar power option available',
                    ],
                ],
                [
                    'heading' => 'Safety and Security Features',
                    'bullets' => [
                        'Anti-crushing protection: sensors detect obstacles and prevent the gate from closing',
                        'Forced opening detection: alerts you if someone tries to force the gate open',
                        'Tamper-proof: secure and tamper-proof design to prevent unauthorized access',
                    ],
                ],
            ],
            'videos' => [
                ['type' => 'reel', 'id' => '878467141148027',  'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '1309013396647864', 'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '1662371720909694', 'w' => 267, 'h' => 476],
            ],
            'ctas' => [
                ['text' => 'Make an Enquiry', 'href' => 'contact', 'style' => 'th-btn'],
            ],
        ],

        'smart-controlled-light-strips' => [
            'title'  => 'Smart Controlled Light Strips',
            'icon'   => 'fas fa-lightbulb',
            'hero'   => 'service/service_1_3.jpg',
            'sections' => [
                [
                    'heading' => 'We can install these lights for you',
                    'text'    => 'Unlike traditional standalone LED strip lights, smart WiFi enabled LED strips connect directly to your home WiFi network, allowing you to control them from anywhere using your smartphone or tablet.',
                ],
            ],
            'videos' => [
                ['type' => 'reel', 'id' => '1635133803706127', 'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '1073055697624228', 'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '488604840875876',  'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '931350905509884',  'w' => 267, 'h' => 476],
            ],
            'ctas' => [
                ['text' => 'For Enquiries Contact Us Now', 'href' => 'contact', 'style' => 'th-btn'],
            ],
        ],

        'lighting-accessories' => [
            'title'  => 'Lighting Accessories',
            'icon'   => 'fas fa-plug',
            'hero'   => 'service/service_1_1.jpg',
            'sections' => [
                [
                    'heading' => 'Controlling Lighting Via Wifi Devices',
                    'text'    => 'How do smart lights work? Smart lights have a chip inside them so that they can communicate with other devices wirelessly. Every light can connect to an app, smart home assistant, or other smart accessory, so you can automate your lights, change their color, or control them remotely.',
                ],
            ],
            'videos' => [],
            'ctas' => [
                ['text' => 'View Accessories on The Store', 'href' => 'store', 'style' => 'th-btn'],
            ],
        ],

        'ai-systems' => [
            'title'  => 'AI Systems',
            'icon'   => 'fas fa-brain',
            'hero'   => 'service/service_1_2.jpg',
            'sections' => [
                ['heading' => 'What are AI Systems?'],
                [
                    'heading' => 'AI SYSTEMS',
                    'text'    => 'AI systems can be standalone computer programs or they can process data from the world and produce behavior in a robot body. After a rather shaky start AI is now a major research area, and it is used to perform tasks ranging from the processing of security camera data to the control of autonomous vehicles.',
                ],
                [
                    'heading' => '3 Types of Artificial Intelligence',
                    'bullets' => [
                        'Artificial Narrow Intelligence (ANI)',
                        'Artificial General Intelligence (AGI)',
                        'Artificial Super Intelligence (ASI)',
                    ],
                ],
            ],
            'videos' => [],
            'ctas' => [
                ['text' => 'Call us for a quote. +27787972186', 'href' => 'tel:+27787972186', 'style' => 'th-btn'],
            ],
        ],

        'robotic-systems' => [
            'title'  => 'Robotic Systems',
            'icon'   => 'fas fa-robot',
            'hero'   => 'service/service_1_3.jpg',
            'sections' => [
                ['heading' => 'What are Robotic Systems?'],
                [
                    'heading' => 'Robotic Systems',
                    'text'    => 'There are three main types of automation systems when considering adding robots to your production line. They are the manipulation robotic system, the mobile robotic system, and the data acquisition and control robotic system.',
                ],
                [
                    'text' => 'Robotic systems are a way of automating manufacturing applications while reducing the amount of labor and production costs and time associated with the process.',
                ],
                [
                    'heading' => 'Manipulation Robot System',
                    'text'    => 'The most commonly used in the manufacturing industry. These systems are made up of many of the robot arms with 4-6 axes and varying degrees of freedom. They can perform several different functions, including welding, material handling and material removal applications.',
                ],
                [
                    'heading' => 'Mobile Robotic System',
                    'text'    => 'This system consists of an automated platform that moves items from one place to another. Used heavily in manufacturing for carrying tools and spare parts, and also in agriculture.',
                ],
                [
                    'heading' => 'Data Acquisition and Control Systems',
                    'text'    => 'Used to gather, process and transmit data for a variety of signals.',
                ],
            ],
            'videos' => [],
            'ctas' => [
                ['text' => 'Call us for a quote. +27787972186', 'href' => 'tel:+27787972186', 'style' => 'th-btn'],
            ],
        ],

        'dcs-systems' => [
            'title'  => 'DCS Systems',
            'icon'   => 'fas fa-network-wired',
            'hero'   => 'service/service_1_1.jpg',
            'sections' => [
                [
                    'heading' => 'What are DCS Systems?',
                    'text'    => 'A distributed control system (DCS) is a computerised control system for a process or plant usually with many control loops, in which autonomous controllers are distributed throughout the system, but there is no central operator supervisory control.',
                ],
                [
                    'text' => 'This is in contrast to systems that use centralized controllers; either discrete controllers located at a central control room or within a central computer. The DCS concept increases reliability and reduces installation costs by localising control functions near the process plant, with remote monitoring and supervision.',
                ],
                [
                    'text' => 'Distributed control systems (DCS) are dedicated systems used in manufacturing processes that are continuous or batch-oriented. Processes where a DCS might be used include:',
                ],
                [
                    'heading' => 'Typical applications',
                    'bullets' => [
                        'Chemical plants',
                        'Petrochemical (oil) and refineries',
                        'Pulp and paper mills',
                        'Boiler controls and power plant systems',
                        'Nuclear power plants',
                        'Environmental control systems',
                        'Water management systems',
                        'Water treatment plants',
                        'Sewage treatment plants',
                        'Food and food processing',
                        'Agrochemical and fertilizer',
                        'Metal and mines',
                        'Automobile manufacturing',
                        'Metallurgical process plants',
                        'Pharmaceutical manufacturing',
                        'Sugar refining plants',
                        'Agriculture applications',
                    ],
                ],
            ],
            'videos' => [],
            'ctas' => [
                ['text' => 'Call us for a quote. +27787972186', 'href' => 'tel:+27787972186', 'style' => 'th-btn'],
            ],
        ],

        'servo-systems' => [
            'title'  => 'Servo Systems',
            'icon'   => 'fas fa-cog',
            'hero'   => 'service/service_1_2.jpg',
            'sections' => [
                [
                    'heading' => 'What are Servo Systems?',
                    'text'    => 'Servo control is the regulation of speed (velocity) and position of a motor based on a feedback signal. The most basic servo loop is the speed loop. Most servo systems require position control in addition to speed control, most commonly provided by adding a position loop in cascade or series with a speed loop.',
                ],
            ],
            'videos' => [],
            'ctas' => [
                ['text' => 'Call us for a quote. +27787972186', 'href' => 'tel:+27787972186', 'style' => 'th-btn'],
            ],
        ],

        'iot-systems' => [
            'title'  => 'IOT Systems',
            'icon'   => 'fas fa-wifi',
            'hero'   => 'service/service_1_3.jpg',
            'sections' => [
                ['heading' => 'What are IOT Systems?'],
                [
                    'heading' => 'IOT SYSTEMS',
                    'text'    => 'The internet of things, or IoT, is a system of interrelated computing devices, mechanical and digital machines, objects, animals or people that are provided with unique identifiers (UIDs) and the ability to transfer data over a network without requiring human-to-human or human-to-computer interaction.',
                ],
                [
                    'text' => 'The main parts of IoT systems are Sensors/devices, connectivity, data processing, and a user interface. Typically an IoT communication is based on: devices (sensors/actuators) for data generation or/and collection.',
                ],
                [
                    'text' => "Home automation can't exist without Internet of Things (IoT), and to control home automation systems including lighting, heating (such as smart thermostats), ventilation, air conditioning (HVAC), and security; you need IoT applications. Here are the key considerations involved with IoT application development.",
                ],
            ],
            'videos' => [],
            'ctas' => [
                ['text' => 'Call us for a quote. +27787972186', 'href' => 'tel:+27787972186', 'style' => 'th-btn'],
            ],
        ],

        'scada-systems' => [
            'title'  => 'SCADA Systems',
            'icon'   => 'fas fa-desktop',
            'hero'   => 'service/service_1_1.jpg',
            'sections' => [
                [
                    'heading' => 'What are SCADA Systems?',
                    'text'    => 'A SCADA (supervisory control and data acquisition) is an automation control system that is used in industries such as energy, oil and gas, water, power, and many more. The system has a centralized system that monitors and controls entire sites, ranging from an industrial plant to a complex of plants across the country.',
                ],
                [
                    'heading' => 'SCADA Systems',
                    'text'    => 'Distributed control systems (DCS) are dedicated systems used in manufacturing processes that are continuous or batch-oriented. Processes where a DCS might be used include:',
                ],
                [
                    'heading' => 'Typical applications',
                    'bullets' => [
                        'Chemical plants',
                        'Petrochemical (oil) and refineries',
                        'Pulp and paper mills',
                        'Boiler controls and power plant systems',
                        'Nuclear power plants',
                        'Environmental control systems',
                        'Water management systems',
                        'Water treatment plants',
                        'Sewage treatment plants',
                        'Food and food processing',
                        'Agrochemical and fertilizer',
                        'Metal and mines',
                        'Automobile manufacturing',
                        'Metallurgical process plants',
                        'Pharmaceutical manufacturing',
                        'Sugar refining plants',
                        'Agriculture applications',
                    ],
                ],
            ],
            'videos' => [],
            'ctas' => [
                ['text' => 'Call us for a quote. +27787972186', 'href' => 'tel:+27787972186', 'style' => 'th-btn'],
            ],
        ],

        'smart-security-sensors' => [
            'title'  => 'Smart Security Sensors',
            'icon'   => 'fas fa-shield-alt',
            'hero'   => 'service/service_1_2.jpg',
            'sections' => [
                [
                    'text' => 'They detect fire, water leakage, and intrusion, then send an alert over the wireless link as quickly as possible - every second counts in time-sensitive emergencies. Accurate connected sensors can save time and lives, protect property, and give peace of mind to users.',
                ],
            ],
            'videos' => [],
            'ctas' => [
                ['text' => 'View Sensors on the Store', 'href' => 'store',   'style' => 'th-btn'],
                ['text' => 'Make an Enquiry',           'href' => 'contact', 'style' => 'th-btn style2'],
            ],
        ],

        'alarm-and-access-control' => [
            'title'  => 'Alarm and Access Control Systems',
            'icon'   => 'fas fa-bell',
            'hero'   => 'service/service_1_3.jpg',
            'sections' => [
                [
                    'text' => "Mazzy Automations' Alarm and Access Control Systems provide a comprehensive security solution for homes, businesses, and institutions. Here are some of its core features:",
                ],
                [
                    'heading' => 'Alarm Systems',
                    'bullets' => [
                        'Intrusion detection: door and window sensors, motion detectors, and glass break sensors',
                        'Alert systems: loud alarms, SMS notifications, and mobile app alerts',
                        '24/7 monitoring: optional monitoring services for rapid response to alarms',
                    ],
                ],
                [
                    'heading' => 'Access Control Systems',
                    'bullets' => [
                        'Secure entry points: electronic doors, gates, and turnstiles',
                        'Authentication methods: RFID cards, biometric scanners, PIN codes, and mobile app access',
                        'Access levels: customizable permissions for different users, groups, or departments',
                        'Real-time monitoring: tracking of who enters or exits, and when',
                    ],
                ],
                [
                    'heading' => 'Integration and Scalability',
                    'bullets' => [
                        'Integration with other systems: compatibility with CCTV cameras, fire alarms, and other security systems',
                        'Scalability: systems can be expanded or modified as security needs change',
                    ],
                ],
                [
                    'text' => "By installing Mazzy Automations' Alarm and Access Control Systems, individuals and organizations can enjoy enhanced security, convenience, and peace of mind.",
                ],
            ],
            'videos' => [
                ['type' => 'reel', 'id' => '978995680663236',  'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '1635133803706127', 'w' => 267, 'h' => 476],
                ['type' => 'reel', 'id' => '543134681659504',  'w' => 267, 'h' => 476],
            ],
            'ctas' => [
                ['text' => 'Make an Enquiry', 'href' => 'contact', 'style' => 'th-btn'],
            ],
        ],

        'smart-monitoring-and-control' => [
            'title'  => 'Smart Monitoring and Control Systems',
            'icon'   => 'fas fa-chart-bar',
            'hero'   => 'service/service_1_1.jpg',
            'sections' => [
                [
                    'heading'    => 'Access Control Systems Installations',
                    'subheading' => 'Serving residential and commercial customers in South Africa, Mazzy Automations specializes in the installation of access control systems.',
                    'text'       => "We can set up an access control system that will enable you to manage entrances to your premises in complete security. This equipment includes devices such as card readers, PIN codes or biometric technologies to verify the identity of visitors. It's a system that records access activity, providing traceability and facilitating employee management. You'll be able to protect your home or premises against intruders and unauthorized access.",
                ],
                [
                    'text' => 'In addition to the installation of access control systems, our services also include alarm installations, security cameras, IP telephony and network and audio and video systems.',
                ],
                [
                    'heading' => 'Get in touch!',
                ],
            ],
            'videos' => [],
            'ctas' => [
                ['text' => 'Call us for a quote. +27787972186', 'href' => 'tel:+27787972186', 'style' => 'th-btn'],
            ],
        ],

        'smart-entertainment-systems' => [
            'title'  => 'Smart Entertainment Systems',
            'icon'   => 'fas fa-tv',
            'hero'   => 'service/service_1_2.jpg',
            'sections' => [
                [
                    'heading'    => 'Audio Solutions Installations',
                    'subheading' => "Take advantage of Mazzy Automation's expertise for your audio and video solution needs in South Africa.",
                    'text'       => "Rely on our technical expertise to install high-end audio equipment, lighting systems and quality screens. Our audio solutions offer an immersive and captivating sound experience, whether for residential or professional spaces. Perfect for professional presentations, entertainment or advertising displays, our state-of-the-art screens guarantee exceptional visual reproduction. As our services are highly diversified, we also specialize in installing alarms, security cameras, IP telephony and network and access control systems.",
                ],
            ],
            'videos' => [
                ['type' => 'reel', 'id' => '476606638771650', 'w' => 267, 'h' => 476],
            ],
            'ctas' => [
                ['text' => 'Call us for a quote. +27787972186', 'href' => 'tel:+27787972186', 'style' => 'th-btn'],
            ],
        ],

    ];

    $service = $services[$slug] ?? null;
    @endphp

    <x-slot:title>{{ $service ? $service['title'] . ' - Mazzy Automations' : 'Solutions - Mazzy Automations' }}</x-slot>

    @if (!$service)
        {{-- Fallback --}}
        <div class="breadcumb-wrapper" data-bg-src="{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}">
            <div class="container">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">Solutions</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                        <li>Solutions</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="space-top space-extra-bottom text-center">
            <div class="container">
                <i class="fas fa-tools fa-4x text-theme mb-4"></i>
                <h2>Solution Not Found</h2>
                <p class="mb-4">The requested solution page could not be found.</p>
                <a href="{{ route('shop.home.index') }}" class="th-btn">Back to Home <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    @else

        {{-- Breadcrumb --}}
        <div class="breadcumb-wrapper" data-bg-src="{{ asset('themes/shop/konta/img/bg/breadcumb-bg.jpg') }}">
            <div class="container">
                <div class="breadcumb-content">
                    <h1 class="breadcumb-title">{{ $service['title'] }}</h1>
                    <ul class="breadcumb-menu">
                        <li><a href="{{ route('shop.home.index') }}">Home</a></li>
                        <li>{{ $service['title'] }}</li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Service Detail --}}
        <div class="space-top space-extra-bottom">
            <div class="container">
                <div class="row gx-5">

                    {{-- Main Content --}}
                    <div class="col-lg-8">
                        <div class="service-detail">

                            {{-- Hero Image --}}
                            <div class="service-detail_img mb-40">
                                <img src="{{ asset('themes/shop/konta/' . $service['hero']) }}" alt="{{ $service['title'] }}" class="w-100 rounded">
                            </div>

                            {{-- Title --}}
                            <div class="title-area mb-30">
                                <span class="sub-title"><i class="{{ $service['icon'] }}"></i> {{ $service['title'] }}</span>
                            </div>

                            {{-- Flexible content sections --}}
                            @foreach($service['sections'] as $section)
                                @if (!empty($section['heading']))
                                    <h3 class="h4 mt-35 mb-15">{{ $section['heading'] }}</h3>
                                @endif

                                @if (!empty($section['subheading']))
                                    <p class="mb-15"><em>{{ $section['subheading'] }}</em></p>
                                @endif

                                @if (!empty($section['text']))
                                    <p class="mb-3">{{ $section['text'] }}</p>
                                @endif

                                @if (!empty($section['bullets']))
                                    <ul class="list-unstyled mb-3">
                                        @foreach($section['bullets'] as $bullet)
                                            <li class="mb-2 d-flex align-items-start">
                                                <i class="fas fa-check-circle text-theme me-3 mt-1 flex-shrink-0"></i>
                                                <span>{{ $bullet }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if (!empty($section['text_after']))
                                    <p class="mb-3">{{ $section['text_after'] }}</p>
                                @endif
                            @endforeach

                            {{-- Facebook Video Embeds --}}
                            @if (!empty($service['videos']))
                                <h4 class="mt-50 mb-30">Our Featured Installations</h4>
                                <div class="d-flex flex-wrap gap-3 mb-40">
                                    @foreach($service['videos'] as $video)
                                        @php
                                            $fbHref = $video['type'] === 'reel'
                                                ? 'https://www.facebook.com/reel/' . $video['id'] . '/'
                                                : 'https://www.facebook.com/mazzyautomations/videos/' . $video['id'] . '/';
                                            $fbSrc = 'https://www.facebook.com/plugins/video.php?href=' . rawurlencode($fbHref) . '&show_text=false&width=' . $video['w'] . '&t=0';
                                        @endphp
                                        <div class="mz-fb-video">
                                            <iframe
                                                src="{{ $fbSrc }}"
                                                width="{{ $video['w'] }}"
                                                height="{{ $video['h'] }}"
                                                style="border:none;overflow:hidden;display:block;"
                                                scrolling="no"
                                                frameborder="0"
                                                allowfullscreen="true"
                                                allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
                                                loading="lazy"
                                            ></iframe>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- CTA Buttons --}}
                            <div class="service-detail_cta d-flex flex-wrap gap-3 mt-40">
                                @foreach($service['ctas'] as $cta)
                                    @php
                                        if (str_starts_with($cta['href'], 'tel:')) {
                                            $ctaHref = $cta['href'];
                                        } elseif ($cta['href'] === 'store') {
                                            $ctaHref = route('shop.home.store');
                                        } else {
                                            $ctaHref = route('shop.home.contact_us');
                                        }
                                    @endphp
                                    <a href="{{ $ctaHref }}" class="{{ $cta['style'] }}">
                                        {{ $cta['text'] }} <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                @endforeach
                            </div>

                        </div>
                    </div>

                    {{-- Sidebar --}}
                    <div class="col-lg-4 mt-5 mt-lg-0">

                        {{-- All Solutions --}}
                        <div class="widget mb-40">
                            <h4 class="widget_title">All Solutions</h4>
                            <ul class="service-menu">
                                @foreach(array_keys($services) as $key)
                                    <li class="{{ $slug === $key ? 'active' : '' }}">
                                        <a href="{{ route('shop.home.solutions', $key) }}">
                                            {{ $services[$key]['title'] }} <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Contact Widget --}}
                        <div class="widget contact-widget">
                            <h4 class="widget_title">Make an Enquiry</h4>
                            <div class="contact-widget_content">
                                <p>Ready to implement {{ $service['title'] }} in your space? Contact our experts for a free assessment and quote.</p>
                                <div class="info-box-wrap mb-3">
                                    <div class="info-box_icon"><i class="fas fa-phone"></i></div>
                                    <div>
                                        <a href="tel:+27787972186" class="info-box_link">+27 787 972 186</a><br>
                                        <a href="tel:0107463674" class="info-box_link">010 746 3674</a>
                                    </div>
                                </div>
                                <div class="info-box-wrap mb-4">
                                    <div class="info-box_icon"><i class="fas fa-envelope"></i></div>
                                    <a href="mailto:info@mazzyautomations.co.za" class="info-box_link">info@mazzyautomations.co.za</a>
                                </div>
                                <a href="{{ route('shop.home.contact_us') }}" class="th-btn w-100 text-center">Make an Enquiry</a>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    @endif
</x-shop::layouts>
