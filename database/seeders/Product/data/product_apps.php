<?php

return [
    [
    'version' => '1.1',
    'name' => [
        'ru' => 'Томографик 1.1 — Дефектоскоп общего назначения',
        'en' => 'Tomographic 1.1 – General Purpose Flaw Detector',
    ],
    'purpose' => 'general',
    'image' => 'apps/tomographic-5m/1.1/thumb.webp',
    'short_description' => [
        'ru' => 'Основное приложение дефектоскопа «Томографик УД4-ТМ» для контроля основного металла и сварных соединений.',
        'en' => 'The main Tomographic UD4-TM flaw detector application for testing base metal and welded joints.',
    ],
    'full_description' => [
        'ru' => <<<'HTML'
<h1>Томографик 1.1 — Дефектоскоп общего назначения</h1>

<p>Основное приложение дефектоскопа «Томографик УД4-ТМ», предназначенное для контроля основного металла и сварных соединений (сварных швов и околошовных зон), реализует функционал ультразвукового дефектоскопа общего назначения.</p>

<p>Встроенная функция отображения хода луча позволяет определять местоположение дефекта в контролируемом объекте. Это особенно актуально при использовании наклонных преобразователей и позволяет визуально оценить глубину залегания и расположение дефекта.</p>

<p>Анализ спектра сигнала, определение частоты отражённого сигнала и вычисление эквивалентной площади дефекта — одни из функций обработки сигналов, реализованных в УД4-Т. Помимо развертки типа A-Scan, программное приложение позволяет строить развертки типов B-Scan, C-Scan и D-Scan, что актуально при контроле сварных швов, а также при оценке расположения дефектов.</p>

<p>Для построения данных разверток и определения положения ПЭП используется двухкоординатный ультразвуковой сканер. Для построения D-развертки применяется дифракционно-временной метод ультразвукового контроля (Time of Flight Diffraction — TOFD). Этот метод применим для выявления дефектов типа «трещина» и измерения глубины их залегания.</p>

<p>Документирование результатов контроля осуществляется непосредственно в приборе УД4-ТМ. Перенос данных на компьютер выполняется с помощью сервисного приложения «АРМ дефектоскописта».</p>

<p>Приложение «Дефектоскоп общего назначения» позволяет:</p>

<ul>
<li>Определять наличие дефектов, связанных с нарушением сплошности и однородности материалов, полуфабрикатов, готовых изделий и сварных соединений;</li>
<li>Измерять глубину дефектов и координаты их залегания;</li>
<li>Определять толщину материала, скорость распространения и затухания ультразвуковых колебаний (УЗК) в материале;</li>
<li>Управлять кривой ВРЧ в двух режимах: ручном и автоматическом;</li>
<li>Применять цифровую фильтрацию для увеличения соотношения «сигнал/шум»;</li>
<li>Задавать параметры ПЭП, такие как частота, задержка в призме и угол ввода, а также загружать их непосредственно из архива ПЭП.</li>
</ul>
HTML,
        'en' => <<<'HTML'
<h1>Tomographic 1.1 – General Purpose Flaw Detector</h1>

<p>It is the main application of the Tomographic UD4-TM flaw detector, intended for testing the base metal and welded joints (weld seams and weld-adjacent zones). It implements the functionality of a general-purpose ultrasonic flaw detector.</p>

<p>The built-in function for displaying the beam path makes it possible to determine the location of flaws in the tested object. This is particularly important when angle probes are used, as it allows visual evaluation of the flaw depth and position.</p>

<p>Signal spectrum analysis, determination of the reflected signal frequency, and calculation of the flaw equivalent area are among the signal processing functions implemented in UD4-TM.</p>

<p>In addition to A-scan, the software allows plotting of B-, C-, and D-scans, which are important for weld testing and flaw location assessment. A 2D ultrasonic scanner is used to plot these scans and determine the PEP position.</p>

<p>D-scan plotting uses the TOFD (Time of Flight Diffraction) ultrasonic testing method. This method is suitable for detecting flaws such as cracks and determining their depth.</p>

<p>Testing results are recorded directly in the UD4-TM instrument, while data can be transferred to a computer using the service application “NDT Operator AWS”.</p>

<h2>Application Features</h2>

<p>The “General Purpose Flaw Detector” application allows the following:</p>

<ul>
<li>Detection of flaws such as discontinuities and inhomogeneities in materials, semi-finished products, finished products, and welded joints.</li>
<li>Measurement of flaw depth and coordinates of their location.</li>
<li>Determination of material thickness, ultrasonic wave (USW) propagation velocity, and attenuation in the material.</li>
<li>DAC curve control in two modes: manual and automatic.</li>
<li>Application of digital filtering to improve the signal-to-noise ratio.</li>
<li>Configuration of PEP parameters, including frequency, wedge delay, and angle, as well as downloading these parameters directly from the PEP archive.</li>
</ul>
HTML,
    ],
    'images' => [
        'apps/tomographic-5m/1.1/1.webp',
        'apps/tomographic-5m/1.1/2.webp',
        'apps/tomographic-5m/1.1/3.webp',
        'apps/tomographic-5m/1.1/4.webp',
    ],
],
[
    'version' => '1.2',
    'name' => [
        'ru' => 'Томографик 1.2 — ЭМА и ультразвуковой толщиномер',
        'en' => 'Tomographic 1.2 – EMA and Ultrasonic Precision Thickness Meter',
    ],
    'purpose' => 'general',
    'image' => 'apps/tomographic-5m/1.2/thumb.webp',
    'short_description' => [
        'ru' => 'Совмещает функции ЭМА и ультразвукового прецизионного толщиномера.',
        'en' => 'Combines the functions of an EMA and an ultrasonic precision thickness meter.',
    ],
    'full_description' => [
        'ru' => <<<'HTML'
<h1>Томографик 1.2 — ЭМА и ультразвуковой толщиномер</h1>

<p>«Томографик 1.2» реализует одновременно функциональные возможности ЭМА (электромагнитоакустического) и ультразвукового прецизионного толщиномера.</p>

<p>Преимущества бесконтактного ЭМА-метода основаны на его физических свойствах, что позволяет проводить контроль объектов без применения контактной жидкости, а также работать с материалами, имеющими загрязнённую поверхность (ржавчина, коррозия и т. п.) и лакокрасочные покрытия. Устойчивая работа ЭМА-датчика обеспечивается при наличии воздушного зазора между датчиком и контролируемой поверхностью в диапазоне 0–1,5 мм в зависимости от электропроводности контролируемого материала.</p>

<h2>Типы преобразователей</h2>

<p>Для измерения толщины используются несколько типов преобразователей:</p>

<ul>
<li>ЭМАП — совмещённый.</li>
<li>ЭМАП — раздельно-совмещённый.</li>
<li>ПЭП — совмещённый.</li>
<li>ПЭП — раздельно-совмещённый.</li>
</ul>

<p>В ЭМА-толщиномере используются три метода обработки сигналов: резонансный, корреляционный и импульсный.</p>

<p>Для каждого из методов рекомендуется выполнять калибровку по образцам, используя толщину образца или скорость распространения ультразвуковых колебаний в нём.</p>

<h2>Резонансный метод</h2>

<p><strong>Измерения резонансным методом используются для особо тонких изделий, где необходим высокий класс точности:</strong></p>

<ul>
<li>От 0,2 до 1 мм (ПЭП).</li>
<li>От 0,3 до 0,7 мм (ЭМАП).</li>
</ul>

<h2>Корреляционный метод</h2>

<p><strong>Измерения корреляционным методом осуществляются при наличии не менее двух донных эхо-сигналов. Погрешность измерения уменьшается с увеличением количества эхо-сигналов. Метод рассчитан на работу в средних диапазонах толщин:</strong></p>

<ul>
<li>От 1 до 60 мм (ПЭП).</li>
<li>От 0,7 до 60 мм (ЭМАП).</li>
</ul>

<h2>Импульсный метод</h2>

<p><strong>Измерения импульсным методом осуществляются по одному донному сигналу. Метод используется для оценочных замеров толщины в следующих диапазонах:</strong></p>

<ul>
<li>От 10 до 4800 мм (ПЭП).</li>
<li>От 5 до 650 мм (ЭМАП).</li>
</ul>

<h2>Функциональные возможности программы</h2>

<p>Программа оснащена новыми функциональными возможностями, позволяющими существенно облегчить работу оператора и ускорить процесс контроля:</p>

<ul>
<li>Автоматическое определение контакта преобразователя (ПЭП или ЭМАП) с контролируемой поверхностью, а также возможность включения и выключения данной функции.</li>
<li>В корреляционном и импульсном методах предусмотрены полуавтоматическая настройка с ручной подстройкой и автоматическая настройка. Это позволяет приступать к контролю объектов без предварительной настройки прибора. В импульсном методе также реализована функция автоматического определения положения первого эхо-импульса, которую можно включать и выключать.</li>
<li>Режимы A-Scan и B-Scan позволяют наглядно отслеживать отклонения толщины от допустимых значений. При недопустимом отклонении прибор подаёт сигнал с помощью индикатора АСД.</li>
<li>Автоматическая регулировка усиления исключает необходимость постоянной установки требуемого значения при смене объекта контроля. Для удобства пользователя также сохранена возможность ручной регулировки.</li>
<li>Наряду с табличным представлением результатов реализована карта толщин, позволяющая оценить объект контроля в целом. Графическое представление наглядно отображает зоны недопустимых отклонений толщины.</li>
<li>Архив настроек позволяет сохранять и загружать необходимые настройки. Архив вмещает до 1000 записей.</li>
<li>Архив результатов контроля позволяет сохранять и загружать необходимые записи, просматривать их непосредственно на приборе, а также формировать отчёты о контроле.</li>
<li>Документирование результатов контроля осуществляется посредством универсального приложения «АРМ дефектоскописта».</li>
</ul>
HTML,
        'en' => <<<'HTML'
<h1>Tomographic 1.2 – EMA and Ultrasonic Precision Thickness Meter</h1>

<p>"Tomographic 1.2" implements simultaneously the functionalities of both an EMA (electromagnetic acoustic) and an ultrasonic precision thickness meter.</p>

<p>The advantages of the contactless EMA method are based on its physical properties, which make it possible to test objects without coupling media, as well as to work with materials having contaminated surfaces (rust, corrosion, etc.) and paint-and-lacquer coatings. Stable operation of the EMA probe (EMAP) is ensured with an air gap between the probe and the tested surface of 0–1.5 mm, depending on the conductivity of the tested material.</p>

<p>For thickness measurement, probes of several types are used:</p>

<ul>
<li>EMAP – single probe</li>
<li>EMAP – dual probe</li>
<li>PEP – single probe</li>
<li>PEP – dual probe</li>
</ul>

<p>Three signal processing methods are used in the EMA thickness meter: resonance, correlation, and pulse.</p>

<p>For each method, calibration using reference blocks is recommended, based on either the block thickness or the ultrasonic wave (USW) propagation velocity in the block.</p>

<p><strong>Measurements using the resonance method are intended for particularly thin articles requiring a high degree of accuracy:</strong></p>

<ul>
<li>0.2 mm to 1 mm (PEP)</li>
<li>0.3 mm to 0.7 mm (EMAP)</li>
</ul>

<p><strong>Measurements using the correlation method are performed when at least two back-wall echo signals are present. Measurement error decreases as the number of echo signals increases. This method is designed for operation within the following thickness ranges:</strong></p>

<ul>
<li>1 mm to 60 mm (PEP)</li>
<li>0.7 mm to 60 mm (EMAP)</li>
</ul>

<p><strong>Measurements using the pulse method are performed using a single back-wall signal and are intended for approximate thickness measurements within the following ranges:</strong></p>

<ul>
<li>10 mm to 4,800 mm (PEP)</li>
<li>5 mm to 650 mm (EMAP)</li>
</ul>

<p>The software includes new features designed to considerably facilitate the operator's work and accelerate the testing process:</p>

<ul>
<li>Automatic detection of contact between the probe (PEP or EMAP) and the tested surface, with the option to enable or disable this function.</li>
<li>In correlation and pulse modes, semi-automatic adjustment (manual fine-tuning) and automatic adjustment are available, allowing testing to begin without preliminary instrument setup. In pulse mode, the software also provides automatic detection of the position of the first echo pulse. This function can also be enabled or disabled.</li>
<li>A-scan and B-scan allow deviations from permissible thickness values to be monitored conveniently. Unacceptable deviations are indicated by the instrument's automatic flaw signaling unit (monitor).</li>
<li>Automatic gain control eliminates the need to continuously adjust the required gain when changing the tested object. Manual adjustment is also available for convenience.</li>
<li>In addition to tabular result presentation, a thickness map is available, allowing the tested object to be evaluated as a whole. Its graphical representation clearly highlights areas with unacceptable thickness deviations.</li>
<li>The settings archive can store up to 1,000 records and allows any required settings to be saved and loaded.</li>
<li>The test results archive allows records to be saved, loaded, and reviewed directly on the instrument screen, as well as used to generate test reports.</li>
<li>Test results are documented using the universal application "NDT Operator AWS".</li>
</ul>
HTML,
    ],
    'images' => [
        'apps/tomographic-5m/1.2/1.webp',
        'apps/tomographic-5m/1.2/2.webp',
        'apps/tomographic-5m/1.2/3.webp',
        'apps/tomographic-5m/1.2/4.webp',
    ],
],
[
    'version' => '1.3',
    'name' => [
        'ru' => 'Томографик 1.3 — Паспортизация ПЭП',
        'en' => 'Tomographic 1.3 – PEP Certification',
    ],
    'purpose' => 'general',
    'image' => 'apps/tomographic-5m/1.3/thumb.webp',
    'short_description' => [
        'ru' => 'Измерение характеристик ПЭП по стандартному образцу, включая угол ввода, задержку в призме, расчёт АЧХ и построение АРД-диаграмм.',
        'en' => 'Measurement of PEP characteristics using a calibration block, including entry angle, wedge delay, amplitude-frequency response, and DGS diagrams.',
    ],
    'full_description' => [
        'ru' => <<<'HTML'
<h1>Томографик 1.3, Паспортизация ПЭП</h1>
<h4>Паспортизация ПЭП (АРД-диаграммы)</h4>

<p>Программное приложение «Паспортизация ПЭП» (АРД-диаграммы) позволяет по стандартному образцу ОН-1 или СО-3Р измерить основные характеристики ПЭП, включая задержку в призме, угол ввода по стали, расчёт АЧХ и построение АРД-диаграмм. Эта функция позволяет на практике применять датчики разных производителей и учитывать их индивидуальную погрешность и степень износа.</p>

<p>На экране присутствуют подсказка, указывающая, от какого отражателя необходимо получить сигнал, и огибающая. Сигнал с наибольшей амплитудой принимается для дальнейших расчётов. Всего достаточно провести три измерения.</p>

<p>После снятия параметров программа позволяет проверить правильность АРД-диаграммы на дефекте с известной эквивалентной площадью, а затем сохранить результаты в архив (рис. 1). Документирование результатов контроля осуществляется посредством универсального приложения «АРМ дефектоскописта». Программа работает с детектированным сигналом, что облегчает визуальное восприятие.</p>

<p><strong>Функциональные возможности:</strong></p>

<ul>
<li>Определение угла ввода, задержки в призме и АРД-диаграммы датчика на стандартных образцах СО-2 и СО-3Р.</li>
<li>Режим проверки АРД-диаграммы.</li>
<li>Визуализация детектированного сигнала.</li>
<li>Автоматическая регулировка усиления.</li>
<li>Архив на 1000 записей.</li>
</ul>
HTML,
        'en' => <<<'HTML'
<h1>Tomographic 1.3 – PEP Certification</h1>
<h4>PEP Certification (DGS Diagrams)</h4>

<p>Using calibration block ON-1 or SO-3R, the “PEP Certification” (DGS diagrams) software application allows measurement of the main PEP characteristics, including delay in wedge, entry angle for steel, calculation of amplitude-frequency response, and plotting of DGS diagrams. From a practical point of view, this function allows the use of probes from various manufacturers, taking into account their individual measurement errors and degree of wear.</p>

<p>A prompt indicating the specific reflector from which a signal must be received, along with the signal envelope, is displayed on the screen. The signal with the highest amplitude is used for further calculations. In total, three measurements are sufficient.</p>

<p>After the parameters have been measured, the application allows verification of the DGS diagram using a flaw with a known equivalent area, followed by saving the results to the archive (Fig. 1). Test results are documented using the universal application “NDT Operator AWS”. The application operates with the detected signal, making visual interpretation easier.</p>

<p><strong>Functional Features:</strong></p>

<ul>
<li>Determination of the entry angle, wedge delay, and probe DGS diagram using calibration blocks SO-2 and SO-3R.</li>
<li>DGS diagram verification mode.</li>
<li>Signal visualization.</li>
<li>Automatic gain control.</li>
<li>Archive for 1,000 records.</li>
</ul>
HTML,
    ],
    'images' => [
        'apps/tomographic-5m/1.3/1.webp',
        'apps/tomographic-5m/1.3/2.webp',
        'apps/tomographic-5m/1.3/3.webp',
        'apps/tomographic-5m/1.3/4.webp',
    ],
],
[
    'version' => '1.4',
    'name' => [
        'ru' => 'Томографик 1.4 — АРМ дефектоскописта',
        'en' => 'Tomographic 1.4 – NDT Operator AWS',
    ],
    'purpose' => 'general',
    'image' => 'apps/tomographic-5m/1.4/thumb.webp',
    'short_description' => [
        'ru' => 'Компьютерная обработка и хранение результатов контроля, полученных из архива дефектоскопа.',
        'en' => 'Computer processing and storage of test results received from the flaw detector archive.',
    ],
    'full_description' => [
        'ru' => <<<'HTML'
<h1>Томографик 1.4, АРМ дефектоскописта</h1>
<h4>АРМ дефектоскописта</h4>

<p>Автоматизированное рабочее место дефектоскописта «АРМ» предназначено для компьютерной обработки и хранения данных о результатах контроля, полученных из архива дефектоскопа. Кроме того, АРМ дефектоскописта позволяет обновлять версии программного обеспечения прибора «Томографик УД4-ТМ», обеспечивает удобный просмотр и навигацию по полученным и сохранённым данным, а также формирование отчётов по результатам контроля.</p>

<h2>Функциональные особенности</h2>

<ul>
<li>Приём результатов контроля из энергонезависимой памяти дефектоскопа по интерфейсам RS-232/USB и запись их в базу данных.</li>
<li>Концепция базового модуля (ядра) и дополнительных модулей (компонентов) для обработки результатов работы конкретных программ: «Дефектоскоп общего назначения», «Толщиномер» и других.</li>
<li>Визуализация с помощью экранных форм всех данных о дефектах, настройках прибора и параметрах датчика для каждого результата, полученного из дефектоскопа.</li>
<li>Перемещение по базам полученных результатов, сортировка записей, а также удаление ненужных записей из баз данных.</li>
<li>Документирование результатов, включая печать отчётов на бумаге и сохранение отчётов на диске в виде отдельных файлов.</li>
</ul>

<p>Программное обеспечение «АРМ» разработано с применением технологии Windows, что обеспечивает удобный пользовательский интерфейс, а также простое чтение и анализ информации на экране ПК.</p>

<h2>Основные режимы работы АРМ</h2>

<ul>
<li>Запись и удаление программ в приборе.</li>
<li>Приём результатов контроля из дефектоскопа.</li>
<li>Работа с полученными данными.</li>
<li>Оформление отчётов по результатам контроля (документирование).</li>
</ul>

<p><strong>Запись и удаление программ, получение информации о приборе, а также печать отчётов осуществляются на вкладке «Менеджер взаимодействия».</strong></p>
HTML,
        'en' => <<<'HTML'
<h1>Tomographic 1.4 – NDT operator AWS</h1>
<h4>NDT Operator AWS (Automated Workplace of the NDT Operator)</h4>

<p>The Automated Workplace of the NDT Operator (AWS) is designed for computer processing and storage of test result data obtained from the flaw detector archive. In addition, NDT Operator AWS allows updating the software versions of the Tomographic UD4-TM, convenient navigation and review of both obtained and saved data, and preparation of test reports.</p>

<h2>Functional Features</h2>

<ul>
<li>Receipt of test results from the non-volatile memory of the flaw detector via the RS-232/USB interface and recording of such data in the database.</li>
<li>Modular architecture consisting of a basic module (kernel) and auxiliary modules (components) for processing the results of specific applications, such as “General Purpose Flaw Detector”, “Thickness Meter”, etc.</li>
<li>Visualization of all data on flaws, instrument settings, and probe parameters for every result received from the flaw detector.</li>
<li>Navigation through databases of obtained results, sorting of records, and removal of unnecessary records from databases.</li>
<li>Documentation of results, including printing reports on paper and saving reports to disk as separate files.</li>
</ul>

<p>The AWS software is developed using Windows technology, providing a user-friendly interface and convenient viewing and analysis of information on a PC display.</p>

<h2>Main AWS Operating Modes</h2>

<ul>
<li>Recording and deleting applications to and from the instrument.</li>
<li>Receiving test results from the flaw detector.</li>
<li>Working with acquired data.</li>
<li>Preparing reports on test results (documentation).</li>
</ul>

<p><strong>Recording and deleting applications, retrieving instrument information, and printing reports are performed using the “Interaction Manager” tab.</strong></p>
HTML,
    ],
    'images' => [
        'apps/tomographic-5m/1.4/1.webp',
        'apps/tomographic-5m/1.4/2.webp',
        'apps/tomographic-5m/1.4/3.webp',
        'apps/tomographic-5m/1.4/4.webp',
    ],
],
[
        'version' => '2.1',
        'name' => [
            'ru' => 'Томографик 2.1 — РД 07.09-97',
            'en' => 'Tomographic 2.1 — RD 07.09-97',
        ],
        'short_description' => [
            'ru' => 'Приложение «Томографик 2.1» реализует комплексный ультразвуковой контроль колёсных пар грузовых и пассажирских вагонов в соответствии с требованиями РД 07.09-97 «Руководство по комплексному ультразвуковому контролю колёсных пар вагонов» с изменениями № 1, 2, 3.',
            'en' => 'The “Tomographic 2.1” application provides comprehensive ultrasonic testing of wheelsets of freight and passenger railway vehicles in accordance with RD 07.09-97, “Guidelines for Comprehensive Ultrasonic Testing of Railway Vehicle Wheelsets,” including amendments No. 1, 2, and 3.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h1>Томографик 2.1 — РД 07.09-97</h1>

<p>Приложение «Томографик 2.1» реализует комплексный ультразвуковой контроль колёсных пар грузовых и пассажирских вагонов в соответствии с требованиями РД 07.09-97 «Руководство по комплексному ультразвуковому контролю колёсных пар вагонов» с изменениями № 1, 2, 3.</p>

<p>Ультразвуковой контроль цельнокатаных колёс выполняется с применением устройства сканирования УСК-4ТМ и обеспечивает контроль необходимых зон за один поворот с возможностью построения томографии и определения координат дефектного участка.</p>

<p>При необходимости сканер УСК-4ТМ комплектуется вихретоковым датчиком для выявления заводских клеймений с целью недопущения перебраковки колёс (ложного срабатывания при обнаружении дефектов в зоне клеймений). Благодаря встроенной многоканальной системе ультразвуковые (УЗ) и вихретоковые (ВТ) датчики работают одновременно.</p>

<p>Концепция приложения «Томографик 2.1» ориентирована на максимальное уменьшение влияния человеческого фактора за счёт реализации следующих режимов:</p>

<ul>
    <li>Слежение за акустическим контактом;</li>
    <li>Полный мониторинг ПЭП;</li>
    <li>Автоматическая отстройка от структурных шумов;</li>
    <li>Визуализация дефектов, включая эквивалентную площадь, глубину залегания и ориентацию в пространстве.</li>
</ul>

<h2>Контролируемые зоны осей колёсных пар и цельнокатаных колёс</h2>

<table>
    <thead>
        <tr>
            <th>Контролируемая зона</th>
            <th>Тип применяемого ПЭП</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th colspan="2">Оси колёсных пар</th>
        </tr>
        <tr>
            <td>Прозвучиваемость</td>
            <td>П111-2.5-К12 или П131-2.5-0°/18° (0°)</td>
        </tr>
        <tr>
            <td>Средняя и дальняя подступичные части, кроме зоны под внешней кромкой ступицы</td>
            <td>П111-2.5-К12 или П131-2.5-0°/18° (0°)</td>
        </tr>
        <tr>
            <td>Ближняя шейка и предподступичная часть (кольца надеты)</td>
            <td>П111-2.5-К12 или П131-2.5-0°/18° (0°)</td>
        </tr>
        <tr>
            <td>Ближняя подступичная часть под внешней кромкой ступицы (кольца надеты)</td>
            <td>П121-2.5-18° или П131-2.5-0°/18° (18°)</td>
        </tr>
        <tr>
            <td>Ближняя шейка и предподступичная часть (кольца сняты)</td>
            <td>П111-2.5-К12 или П131-2.5-0°/18° (0°)</td>
        </tr>
        <tr>
            <td>Ближняя подступичная часть под внешней кромкой ступицы (кольца сняты)</td>
            <td>П121-2.5-50°</td>
        </tr>
        <tr>
            <td>Средняя и дальняя подступичные части, кроме зоны под внешней кромкой ступицы (подтверждение)</td>
            <td>П111-2.5-К12 или П131-2.5-0°/18° (0°)</td>
        </tr>
        <tr>
            <td>Ближняя шейка и предподступичная часть (кольца надеты) (подтверждение)</td>
            <td>П111-5.0-К6</td>
        </tr>
        <tr>
            <th colspan="2">Цельнокатаные колёса</th>
        </tr>
        <tr>
            <td>Гребень</td>
            <td>П121-2.5-50°-003 в составе УСК-4ТМ</td>
        </tr>
        <tr>
            <td>Основное сечение обода</td>
            <td>П121-2.5-40°-003 в составе УСК-4ТМ</td>
        </tr>
        <tr>
            <td>Приободная зона диска</td>
            <td>П121-2.5-40°-003 в составе УСК-4ТМ</td>
        </tr>
        <tr>
            <td>Поверхность катания</td>
            <td>П121-0.4-90°</td>
        </tr>
    </tbody>
</table>

<p>Поставляемая вместе с дефектоскопом «Томографик УД4-ТМ» специальная программа «АРМ Дефектоскописта ЖД» позволяет документировать результаты контроля, сохранять их в электронной базе данных и формировать паспорт колёсной пары.</p>

<p>Также при поставке в прибор встраиваются обучающие демонстрационные ролики по работе со специализированными приложениями, которые существенно упрощают ознакомление с прибором.</p>
HTML,
            'en' => <<<'HTML'
<h1>Tomographic 2.1 — RD 07.09-97</h1>

<p>The “Tomographic 2.1” application provides comprehensive ultrasonic testing of wheelsets of freight and passenger railway vehicles in accordance with RD 07.09-97, “Guidelines for Comprehensive Ultrasonic Testing of Railway Vehicle Wheelsets,” including amendments No. 1, 2, and 3.</p>

<p>Ultrasonic testing of solid-rolled wheels is performed using the USK-4TM scanning device. It ensures inspection of the required zones in a single revolution, with the ability to generate tomographic images and determine the coordinates of defective areas.</p>

<p>If required, the USK-4TM scanner can be equipped with an eddy-current probe to detect manufacturer’s markings and prevent unnecessary rejection of wheels due to false flaw indications in marked areas. Thanks to the built-in multichannel system, ultrasonic and eddy-current probes operate simultaneously.</p>

<p>The “Tomographic 2.1” application is designed to minimize human error through the implementation of the following operating modes:</p>

<ul>
    <li>Acoustic contact monitoring;</li>
    <li>Comprehensive PEP monitoring;</li>
    <li>Automatic suppression of structural noise;</li>
    <li>Flaw visualization, including equivalent area, depth of location, and spatial orientation.</li>
</ul>

<h2>Inspected Zones of Wheelset Axles and Solid-Rolled Wheels</h2>

<table>
    <thead>
        <tr>
            <th>Inspected Zone</th>
            <th>Probe Type</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th colspan="2">Wheelset Axles</th>
        </tr>
        <tr>
            <td>Ultrasonic wave penetration</td>
            <td>P111-2.5-K12 or P131-2.5-0°/18° (0°)</td>
        </tr>
        <tr>
            <td>Middle and far sections of the wheel seat, excluding the area beneath the outer edge of the hub</td>
            <td>P111-2.5-K12 or P131-2.5-0°/18° (0°)</td>
        </tr>
        <tr>
            <td>Near journal and section adjacent to the wheel seat (rings installed)</td>
            <td>P111-2.5-K12 or P131-2.5-0°/18° (0°)</td>
        </tr>
        <tr>
            <td>Near section of the wheel seat beneath the outer edge of the hub (rings installed)</td>
            <td>P121-2.5-18° or P131-2.5-0°/18° (18°)</td>
        </tr>
        <tr>
            <td>Near journal and section adjacent to the wheel seat (rings removed)</td>
            <td>P111-2.5-K12 or P131-2.5-0°/18° (0°)</td>
        </tr>
        <tr>
            <td>Near section of the wheel seat beneath the outer edge of the hub (rings removed)</td>
            <td>P121-2.5-50°</td>
        </tr>
        <tr>
            <td>Middle and far sections of the wheel seat, excluding the area beneath the outer edge of the hub (confirmation inspection)</td>
            <td>P111-2.5-K12 or P131-2.5-0°/18° (0°)</td>
        </tr>
        <tr>
            <td>Near journal and section adjacent to the wheel seat (rings installed, confirmation inspection)</td>
            <td>P111-5.0-K6</td>
        </tr>
        <tr>
            <th colspan="2">Solid-Rolled Wheels</th>
        </tr>
        <tr>
            <td>Wheel flange</td>
            <td>P121-2.5-50°-003 as part of the USK-4TM system</td>
        </tr>
        <tr>
            <td>Main section of the rim</td>
            <td>P121-2.5-40°-003 as part of the USK-4TM system</td>
        </tr>
        <tr>
            <td>Disc area adjacent to the rim</td>
            <td>P121-2.5-40°-003 as part of the USK-4TM system</td>
        </tr>
        <tr>
            <td>Tread surface</td>
            <td>P121-0.4-90°</td>
        </tr>
    </tbody>
</table>

<p>The specialized “Railway NDT Operator AWS” software supplied with the Tomographic UD4-TM flaw detector allows test results to be documented and stored in electronic databases, as well as wheelset certificates to be generated.</p>

<p>In addition, the instrument is supplied with built-in training videos demonstrating how to operate specialized applications, significantly simplifying the process of becoming familiar with the instrument.</p>
HTML,
        ],
        'purpose' => 'railway',
        'image' => 'apps/tomographic-5m/2.1/thumb.webp',
        'images' => [
            'apps/tomographic-5m/2.1/1.webp',
            'apps/tomographic-5m/2.1/2.webp',
            'apps/tomographic-5m/2.1/3.webp',
            'apps/tomographic-5m/2.1/4.webp',
        ],
    ],
    [
        'version' => '2.1.3',
        'name' => [
            'ru' => 'Томографик 2.1.3 — Контроль пассажирских поездов',
            'en' => 'Tomographic 2.1.3 — Passenger Train Testing',
        ],
        'short_description' => [
            'ru' => 'Ультразвуковой контроль элементов колёсных пар пассажирских поездов.',
            'en' => 'Ultrasonic testing of wheelset elements of passenger trains.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<div class="rounded-lg border border-slate-200 bg-white p-4">
    <div class="grid grid-cols-1 items-center gap-5 md:grid-cols-[1fr_240px]">
        <div>
            <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                ПРИЛОЖЕНИЯ ДЛЯ КОНТРОЛЯ ПАССАЖИРСКИХ ПОЕЗДОВ
            </div>

            <h3 class="mt-2 text-lg font-semibold text-slate-900">
                ТОМОГРАФИК 2.1.3
            </h3>

            <p class="mt-2 text-sm font-medium text-slate-700">
                Ультразвуковой контроль элементов колёсных пар пассажирских поездов
            </p>

            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                Неразрушающий ультразвуковой контроль цельнокатаных колёс с плоскоконическим диском
                пассажирских поездов колеи 1520 мм при их освидетельствовании, ремонте и формировании
                составов в процессе эксплуатации.
            </p>
        </div>
    </div>
</div>
HTML,
            'en' => <<<'HTML'
<div class="rounded-lg border border-slate-200 bg-white p-4">
    <div class="grid grid-cols-1 items-center gap-5 md:grid-cols-[1fr_240px]">
        <div>
            <div class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                APPLICATIONS FOR TESTING PASSENGER TRAINS
            </div>

            <h3 class="mt-2 text-lg font-semibold text-slate-900">
                TOMOGRAPHIC 2.1.3
            </h3>

            <p class="mt-2 text-sm font-medium text-slate-700">
                Ultrasonic testing of wheelset elements of passenger trains
            </p>

            <p class="mt-2 text-sm leading-relaxed text-slate-600">
                Non-destructive ultrasonic testing of wrought wheels with a flat-conical disk for passenger
                trains with locomotive track gauge of 1,520 mm, during their inspection, repair and train setting
                within the operation
            </p>
        </div>

        <div class="flex items-center justify-center">
            <img
                src="/image/features/tomographic_5m/TOMOGRAPHIC 2_1_3.webp"
                alt="TOMOGRAPHIC 2.1.3"
                class="h-auto w-full max-w-[240px] object-contain"
                loading="lazy"
            />
        </div>
    </div>
</div>
HTML,
        ],
        'purpose' => 'railway',
        'image' => 'apps/tomographic-5m/2.1.3/thumb.webp',
        'images' => [],
    ],
    [
        'version' => '2.2',
        'name' => [
            'ru' => 'Томографик 2.2 — РД 32.144-2000',
            'en' => 'Tomographic 2.2 — RD 32.144-2000',
        ],
        'short_description' => [
            'ru' => 'Специализированное программное приложение «Томографик 2.2» (Ось-270) реализует методику контроля черновых и чистовых железнодорожных осей в соответствии с РД 32.144-2000 и РМИ 230-015-87. Методика ультразвукового контроля предназначена для выявления непрозвучиваемых зон и поиска несплошностей в железнодорожных осях всех типов (катаных и сплошных) при приёмосдаточном контроле.',
            'en' => 'The specialized software application “Tomographic 2.2” (Axle-270) implements the testing procedure for rough and finished railway axles in accordance with RD 32.144-2000 and RMI 230-015-87. The ultrasonic testing procedure is intended to detect areas where ultrasonic waves cannot penetrate and to identify discontinuities in railway axles of all types (rolled and solid) during acceptance inspection.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h1>Томографик 2.2 — РД 32.144-2000</h1>

<p>Специализированное программное приложение «Томографик 2.2» (Ось-270) реализует методику контроля черновых и чистовых железнодорожных осей в соответствии с РД 32.144-2000 и РМИ 230-015-87. Методика ультразвукового контроля предназначена для выявления непрозвучиваемых зон и поиска несплошностей в железнодорожных осях всех типов (катаных и сплошных) при приёмосдаточном контроле.</p>

<p>Настройка чувствительности при контроле прозвучиваемости выполняется в соответствии с РД 32.144-2000 по донному эхо-сигналу в стандартном образце СО-2. Также предусмотрена возможность настройки на стандартном образце предприятия с альтернативными эталонными отражателями, обеспечивающими воспроизводимость настройки чувствительности.</p>

<p>Настройка чувствительности при контроле на наличие дефектов выполняется по отраслевым образцам или стандартным образцам предприятия с плоскодонными эталонными отражателями, расположенными на минимальной, средней и близкой к максимальной глубине контролируемой зоны.</p>

<p>Контроль осей и осевых заготовок производится с помощью оптического координатного устройства «ОСЬ-270», предназначенного для определения положения ПЭП на торце заготовки. Использование координатного устройства позволяет не только определять глубину залегания дефекта, но и устанавливать его положение относительно центра заготовки, а также контролировать перемещение ПЭП.</p>

<p>В процессе контроля на экране дефектоскопа схематически отображается торец оси с указанием точек, в которых осуществляется контроль. Программа автоматически отслеживает наличие оптического контакта между координатным устройством и ПЭП.</p>

<p>Управление программой в процессе контроля осуществляется как с помощью клавиш на лицевой панели прибора, так и с помощью клавиатуры, расположенной на координатном устройстве.</p>

<p>По окончании контроля результаты заносятся в архив. Для сохранения результатов необходимо ввести номер оси и номер плавки. Ввод данных осуществляется с помощью клавиш на лицевой панели прибора или клавиатуры координатного устройства.</p>

<p>Документирование результатов контроля выполняется с помощью универсального приложения «АРМ дефектоскописта».</p>

<h2>Функциональные возможности</h2>

<ul>
    <li>Настройка на стандартных образцах и образцах предприятия с альтернативными отражателями.</li>
    <li>Отслеживание перемещения ПЭП на торце осевой заготовки.</li>
    <li>Архив настроек и архив результатов контроля.</li>
    <li>Автоматическая регулировка усиления.</li>
    <li>Управление процессом контроля с помощью клавиатуры координатного устройства.</li>
</ul>
HTML,
            'en' => <<<'HTML'
<h1>Tomographic 2.2 — RD 32.144-2000</h1>

<p>The specialized software application “Tomographic 2.2” (Axle-270) implements the testing procedure for rough and finished railway axles in accordance with RD 32.144-2000 and RMI 230-015-87. The ultrasonic testing procedure is intended to detect areas where ultrasonic waves cannot penetrate and to identify discontinuities in railway axles of all types (rolled and solid) during acceptance inspection.</p>

<p>During ultrasonic penetration testing, sensitivity is adjusted in accordance with RD 32.144-2000 using the back-wall echo signal from the SO-2 calibration block. Alternatively, sensitivity can be adjusted using an enterprise reference block with alternative calibration reflectors that ensure repeatability of sensitivity settings.</p>

<p>When testing for flaws, sensitivity is adjusted using industry-standard or enterprise reference blocks with flat-bottom reflectors located at the minimum, intermediate, and near-maximum depths of the tested area.</p>

<p>Axles and axle billets are tested using the AXLE-270 optical coordinate device, which is designed to determine the PEP position on the end face of the billet. In addition to determining flaw depth, the coordinate device makes it possible to establish the flaw position relative to the center of the billet and monitor PEP movement.</p>

<p>During testing, a schematic representation of the axle end face, showing the inspection points, is displayed on the flaw detector screen. The software automatically monitors the presence of optical contact between the coordinate device and the PEP.</p>

<p>The application can be controlled during testing using either the buttons on the front panel of the instrument or the keypad on the coordinate device.</p>

<p>Upon completion of testing, the results are saved in the archive. To store the results, the axle number and heat number must be entered. These numbers can be entered using either the buttons on the instrument's front panel or the keypad on the coordinate device.</p>

<p>Test results are documented using the universal application “NDT Operator AWS”.</p>

<h2>Functional Features</h2>

<ul>
    <li>Setup using both calibration blocks and enterprise reference blocks with alternative reflectors.</li>
    <li>Monitoring of PEP movement on the end face of the axle billet.</li>
    <li>Archives for settings and test results.</li>
    <li>Automatic gain control.</li>
    <li>Control of the testing process using the coordinate device keypad.</li>
</ul>
HTML,
        ],
        'purpose' => 'railway',
        'image' => 'apps/tomographic-5m/2.2/thumb.webp',
        'images' => [
            'apps/tomographic-5m/2.2/1.webp',
            'apps/tomographic-5m/2.2/2.webp',
            'apps/tomographic-5m/2.2/3.webp',
            'apps/tomographic-5m/2.2/4.webp',
        ],
    ],
    [
        'version' => '2.3',
        'name' => [
            'ru' => 'Томографик 2.3 — УЗ-контроль деталей локомотивов',
            'en' => 'Tomographic 2.3 — Ultrasonic Testing of Locomotive Parts',
        ],
        'short_description' => [
            'ru' => 'Приложение «Томографик 2.3» предназначено для ультразвукового контроля деталей локомотивов серий: ЧС2, ЧС2т, ЧС4, ЧС4т, ЧС7, ВЛ, 2ТЭ116, 2ТЭ10, М62, ТЭМ2, ЧМЭ-3, ЭР1, ЭР2, ЭР9, ЭД4м, ЭТ2.',
            'en' => 'The “Tomographic 2.3” application is designed for ultrasonic testing of parts of the following locomotive series: ChS2, ChS2t, ChS4, ChS4t, ChS7, VL, 2TE116, 2TE10, M62, TEM2, ChME3, ER1, ER2, ER9, ED4m, and ET2.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h1>Томографик 2.3 — УЗ-контроль деталей локомотивов</h1>

<p>Приложение «Томографик 2.3» предназначено для ультразвукового контроля деталей локомотивов серий: ЧС2, ЧС2т, ЧС4, ЧС4т, ЧС7, ВЛ, 2ТЭ116, 2ТЭ10, М62, ТЭМ2, ЧМЭ-3, ЭР1, ЭР2, ЭР9, ЭД4м, ЭТ2.</p>

<p>Спектр контролируемых деталей включает: ось, бандаж, поверхность катания, межзубьевую впадину, болт крепления полюсов ТЭД, болт подвешивания, карданный вал, вал малой шестерни, удлинённую ступицу, серьгу подвешивания и валик подвески.</p>

<p>Методика комплексного ультразвукового контроля деталей локомотивов и МВПС применима на предприятиях, занимающихся изготовлением, эксплуатацией и ремонтом деталей локомотивов, включая ультразвуковой контроль в процессе восстановления изношенных элементов или их термического упрочнения.</p>

<p>Контроль бандажей выполняется с использованием сканирующего устройства УСК-ТЛ, существенно сокращающего время и трудоёмкость контроля. В УСК-ТЛ встроен датчик пути, позволяющий строить томографические изображения и определять координаты дефектных участков, а также вихретоковый датчик для выявления заводских клеймений бандажей с целью предотвращения перебраковки (ложного срабатывания при обнаружении дефектов в зоне клеймений). Благодаря встроенной многоканальной системе ультразвуковой и вихретоковый датчики работают одновременно.</p>

<p>Концепция развития «Томографик 2.3» ориентирована на максимальное уменьшение влияния человеческого фактора за счёт реализации следующих режимов:</p>

<ul>
    <li>Слежение за акустическим контактом;</li>
    <li>Полный мониторинг ПЭП;</li>
    <li>Анализ затухания ультразвуковых волн в контролируемых материалах;</li>
    <li>Визуализация дефектов, включая эквивалентную площадь, глубину залегания и ориентацию в пространстве.</li>
</ul>

<p>В приложение встроены обучающие демонстрационные ролики для быстрого ознакомления с его функциональными возможностями.</p>

<h2>Функциональные особенности</h2>

<ul>
    <li>Автоматическое вычисление расстояния до дефекта и его проекций на оси X и Y.</li>
    <li>Автоматическая регулировка усиления, позволяющая сократить время на подбор необходимого значения усиления.</li>
    <li>Архив результатов, позволяющий просматривать всю необходимую информацию о параметрах и результатах контроля.</li>
    <li>Документирование результатов контроля с помощью универсального приложения «АРМ дефектоскописта».</li>
</ul>

<p>Для контроля зубьев колёс и шестерён применяются специализированные клиновидные ПЭП с углами клина 49° и 72°, предназначенные для установки в межзубьевую канавку.</p>
HTML,
            'en' => <<<'HTML'
<h1>Tomographic 2.3 — Ultrasonic Testing of Locomotive Parts</h1>

<p>The “Tomographic 2.3” application is designed for ultrasonic testing of parts of the following locomotive series: ChS2, ChS2t, ChS4, ChS4t, ChS7, VL, 2TE116, 2TE10, M62, TEM2, ChME3, ER1, ER2, ER9, ED4m, and ET2.</p>

<p>The range of inspected parts includes axles, wheel tires, tread surfaces, tooth spaces, electric traction motor (ETM) pole securing bolts, suspension bolts, cardan shafts, pinion shafts, extended hubs, suspension shackles, and suspension rods.</p>

<p>The comprehensive ultrasonic testing procedure for locomotive and multiple-unit rolling stock (MURS) components is applicable at enterprises involved in the manufacture, operation, and repair of locomotive parts, including ultrasonic testing during the restoration of worn components or their thermal strengthening.</p>

<p>Wheel tire testing is performed using the USK-TL scanning device, which significantly reduces testing time and labor. The USK-TL incorporates a built-in travel sensor that enables the generation of tomographic images and determination of the coordinates of defective areas. It also includes an eddy-current probe for detecting manufacturer’s markings on wheel tires to prevent unnecessary rejection caused by false flaw indications in marked areas. Thanks to the built-in multichannel system, the ultrasonic and eddy-current probes operate simultaneously.</p>

<p>The development concept of “Tomographic 2.3” is focused on minimizing human error through the implementation of the following operating modes:</p>

<ul>
    <li>Acoustic contact monitoring;</li>
    <li>Comprehensive PEP monitoring;</li>
    <li>Analysis of ultrasonic attenuation in the tested materials;</li>
    <li>Flaw visualization, including equivalent area, depth of location, and spatial orientation.</li>
</ul>

<p>Built-in training videos facilitate quick familiarization with the application.</p>

<h2>Functional Features</h2>

<ul>
    <li>Automatic calculation of the distance to a flaw and its projections onto the X and Y axes.</li>
    <li>Automatic gain control, eliminating the need for the operator to spend time selecting the appropriate gain setting.</li>
    <li>A results archive that allows users to review all relevant information about testing parameters and results.</li>
    <li>Documentation of test results using the universal “NDT Operator AWS” application.</li>
</ul>

<p>For testing wheel and pinion gear teeth, specialized wedge-shaped PEPs with wedge angles of 49° and 72° are used. These probes are designed to fit into the grooves between the teeth.</p>
HTML,
        ],
        'purpose' => 'railway',
        'image' => 'apps/tomographic-5m/2.3/thumb.webp',
        'images' => [
            'apps/tomographic-5m/2.3/1.webp',
            'apps/tomographic-5m/2.3/2.webp',
            'apps/tomographic-5m/2.3/3.webp',
            'apps/tomographic-5m/2.3/4.webp',
        ],
    ],
    [
        'version' => '2.4',
        'name' => [
            'ru' => 'Томографик 2.4 — СТО ФПК 1.11.001-2011',
            'en' => 'Tomographic 2.4 — FPC Industry Standard 1.11.001-2011',
        ],
        'short_description' => [
            'ru' => 'Приложение «Томографик 2.4» реализует комплексный ультразвуковой контроль колёсных пар грузовых вагонов в соответствии с требованиями СТО ФПК 1.11.001-2011 «Система неразрушающего контроля в ОАО „ФПК“. Элементы колёсных пар пассажирских вагонов колеи 1520 мм. Требования к ультразвуковому контролю».',
            'en' => 'Application "Tomographic 2.4" implements the combined ultrasonic testing of cargo vehicle wheel sets in accordance with requirements of the FPC Industry Standard 1.11.001-2011 "Nondestructive testing system in the OJSC FPC. Elements of wheel sets of passenger vehicles of 1,520 mm track gauge. Ultrasonic testing requirements".',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h1>Томографик 2.4 — СТО ФПК 1.11.001-2011</h1>

<p>Приложение «Томографик 2.4» реализует комплексный ультразвуковой контроль колёсных пар грузовых вагонов в соответствии с требованиями СТО ФПК 1.11.001-2011 «Система неразрушающего контроля в ОАО „ФПК“. Элементы колёсных пар пассажирских вагонов колеи 1520 мм. Требования к ультразвуковому контролю».</p>

<p>Специализированная методика «Томографик 2.4» предусматривает:</p>

<ul>
    <li>Ручной ультразвуковой контроль осей колёсных пар по вариантам методов AR1.1, AR1.2, AR1.3, AR1.4, AR1.5, AR2, AR3, AR3.1, AR3.2, AR4, AR5.1, AR5.2, AR5.3, TR1, TR2;</li>
    <li>Механизированный ультразвуковой контроль осей колёсных пар по вариантам методов BR1, BR2, BR3, BR4;</li>
    <li>Механизированный ультразвуковой контроль цельнокатаных колёс колёсных пар по вариантам методов DR1.1, DR1.2, DR2.1, DR2.2, DR3.1, DR3.2, DR3.3, WR;</li>
    <li>Ручной ультразвуковой контроль цельнокатаных колёс колёсных пар по варианту метода DR4.</li>
</ul>

<p>Механизированный ультразвуковой контроль цельнокатаных колёс выполняется с применением устройства сканирования УСК-5ТМ. Оно обеспечивает контроль необходимых зон за один поворот с возможностью построения томографических изображений и определения координат дефектного участка.</p>

<p>При необходимости сканер УСК-5ТМ комплектуется вихретоковым датчиком для выявления заводских клеймений с целью предотвращения перебраковки колёс из-за ложных срабатываний в зоне клеймений. Благодаря встроенной многоканальной системе ультразвуковой и вихретоковый датчики работают одновременно.</p>

<p>Механизированный контроль осей колёсных пар с применением сканирующего устройства УСО-1ТМ проводится с предподступичной части. Он обеспечивает контроль необходимых зон за один поворот без демонтажа буксового узла, с возможностью построения томографических изображений и определения координат дефектного участка.</p>

<p>Для предварительной подготовки контролируемой поверхности и очистки от эксплуатационных загрязнений предлагается механический сканер очистки УОО-1Т со сменными кассетами (ножами).</p>

<p>При проведении ультразвукового контроля цельнокатаных колёс и осей колёсных пар с применением сканирующих устройств УСК-5ТМ и УСО-1ТМ на экране дефектоскопа отображается A-скан текущей контролируемой зоны. При этом работают все ПЭП, входящие в состав сканирующего устройства. Данные по всем ПЭП в процессе контроля, при перемещении устройства по контролируемому объекту, отображаются на C-скане.</p>

<p>Концепция приложения «Томографик 2.4» ориентирована на максимальное уменьшение влияния человеческого фактора за счёт реализации следующих функций:</p>

<ul>
    <li>Автоматическая регулировка усиления, позволяющая сократить время на подбор необходимого значения усиления;</li>
    <li>Слежение за акустическим контактом;</li>
    <li>Полный мониторинг ПЭП;</li>
    <li>Автоматическая отстройка от структурных шумов;</li>
    <li>Визуализация дефектов, включая эквивалентную площадь, глубину залегания и ориентацию в пространстве.</li>
</ul>

<p>Поставляемая вместе с дефектоскопом УД4-ТМ специальная программа «АРМ дефектоскописта ЖД» позволяет документировать результаты контроля, сохранять их в электронной базе данных и формировать паспорт колёсной пары.</p>

<p>Кроме того, в прибор встраиваются обучающие демонстрационные ролики по работе со специализированными приложениями, которые существенно упрощают ознакомление с прибором.</p>
HTML,
            'en' => <<<'HTML'
<h2>Tomographic 2.4, FPC Industry Standard 1.11.001-2011</h2>

<p>Application "Tomographic 2.4" implements the combined ultrasonic testing of cargo vehicle wheel sets in accordance with requirements of the FPC Industry Standard 1.11.001-2011 "Nondestructive testing system in the OJSC FPC. Elements of wheel sets of passenger vehicles of 1,520 mm track gauge. Ultrasonic testing requirements".</p>

<p>Specialized technique of "Tomographic 2.4" provides the following:</p>

<ul>
    <li>manual ultrasonic testing of wheel set axles under method options AR1.1, AR1.2, AR1.3, AR1.4, AR1.5, AR2, AR3, AR3.1, AR3.2, AR4, AR5.1, AR5.2, AR5.3, TR1, TR2;</li>
    <li>mechanized ultrasonic testing of wheel set axles under method options BR1, BR2, BR3, BR4;</li>
    <li>mechanized ultrasonic testing of wheelset wrought wheels under method options DR1.1, DR1.2, DR2.1, DR2.2, DR3.1, DR3.2, DR3.3, WR;</li>
    <li>manual ultrasonic testing of wheelset wrought wheels under method option DR4.</li>
</ul>

<p>Mechanized ultrasonic testing of wheelset wrought wheels is performed using the scanning device USK-5TM and ensures control of the required zones in a single revolution, with the possibility of tomographic imaging and determination of the coordinates of defective areas.</p>

<p>If required, the USK-5TM scanner is equipped with an eddy-current probe to detect manufacturer’s marks and prevent the over-rejection of wheels (false flaw indications in the marking area). Thanks to the built-in multichannel system, the ultrasonic and eddy-current probes operate simultaneously.</p>

<p>Mechanized ultrasonic testing of wheelset axles is performed using the USO-1TM scanning device in the area ahead of the wheel seat. It ensures inspection of the required zones in a single revolution without dismantling the axle box, with the possibility of tomographic imaging and determination of the coordinates of defective areas. For preliminary preparation of the test surface by removing operational contamination, a mechanical cleaning scanner, UOO-1T, with replaceable cartridges (blades) is available.</p>

<p>During ultrasonic testing of wrought wheels and wheelset axles using the USK-5TM and USO-1TM scanning devices, the A-scan of the current zone is displayed on the flaw detector screen, with all probes included in the scanning device operating simultaneously. During testing, data from all probes are displayed on the C-scan as the device moves over the tested object.</p>

<p>Concept of the "Tomographic 2.4" application is oriented toward minimizing the human factor by implementing the following functions:</p>

<ul>
    <li>automatic gain control, eliminating the need to spend time selecting the required gain;</li>
    <li>acoustic contact tracing;</li>
    <li>full PEP monitoring;</li>
    <li>automatic suppression of structural noise;</li>
    <li>visualization of flaws, including equivalent area, location depth and spatial orientation.</li>
</ul>

<p>Special software "Railway NDT Operator AWS", supplied with the Tomographic UD4-TM flaw detector, allows test results to be documented and stored in an electronic database, as well as wheelset certificates to be generated. Training demonstration videos covering the operation of specialized applications are also pre-installed in the instrument, significantly simplifying familiarization with its functionality.</p>
HTML,
        ],
        'purpose' => 'railway',
        'image' => null,
        'images' => [
        ],
    ],
 [
        'version' => '2.5',
        'name' => [
            'ru' => 'Томографик 2.5 — РД 32.150-2000',
            'en' => 'Tomographic 2.5 — RD 32.150-2000',
        ],
        'short_description' => [
            'ru' => 'Специализированное программное приложение «Томографик 2.5» (ВТ Вагоны) предназначено для контроля деталей и узлов грузовых и пассажирских вагонов вихретоковым методом в соответствии с РД 32.150-2000 с целью выявления поверхностных и подповерхностных дефектов, в том числе дефектов усталостного и коррозионного происхождения. Программа обладает широким спектром возможностей при достаточной простоте эксплуатации.',
            'en' => 'Specialized software application Tomographic 2.5 (EC Vehicles) is intended for eddy-current testing of parts and assemblies of freight and passenger railway cars in accordance with RD 32.150-2000 to detect surface and subsurface flaws, including defects of fatigue and corrosion origin. The application offers a wide range of features while remaining easy to operate.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h2>Томографик 2.5, РД 32.150-2000</h2>

<p>Специализированное программное приложение «Томографик 2.5» (ВТ Вагоны) предназначено для контроля деталей и узлов грузовых и пассажирских вагонов вихретоковым методом в соответствии с РД 32.150-2000 с целью выявления поверхностных и подповерхностных дефектов, в том числе дефектов усталостного и коррозионного происхождения. Программа обладает широким спектром возможностей при достаточной простоте эксплуатации.</p>

<p>Процесс настройки методики контроля значительно упрощён за счёт использования в «Томографик УД4-ТМ» функции автоматической подстройки оптимальной частоты преобразователя. Для снижения трудоёмкости и повышения достоверности контроля «Томографик 2.5» поддерживает устройства слежения за траекторией перемещения преобразователя (томографический сканер и др.).</p>

<p>Характерные особенности ПО:</p>

<ul>
    <li>Отображение сигнала в комплексной плоскости и временная развёртка проекций сигнала;</li>
    <li>Архив до 500 настроек и 1000 изображений дефектов;</li>
    <li>Контроль грубых и необработанных поверхностей;</li>
    <li>Оценка глубины и протяжённости дефекта;</li>
    <li>Визуализация траектории сканирования и графических подсказок.</li>
</ul>

<p>Документирование результатов контроля осуществляется посредством универсального приложения «АРМ Дефектоскописта», входящего в базовый комплект поставки.</p>

<p>Обучающий ролик, прилагаемый к методике, позволяет ознакомиться со всеми этапами работы по РД 32.150-2000 как на ПК, так и непосредственно на дефектоскопе.</p>
HTML,
            'en' => <<<'HTML'
<h2>Tomographic 2.5, RD 32.150-2000</h2>

<p>Specialized software application Tomographic 2.5 (EC Vehicles) is intended for eddy-current testing of parts and assemblies of freight and passenger railway cars in accordance with RD 32.150-2000 to detect surface and subsurface flaws, including defects of fatigue and corrosion origin. The application offers a wide range of features while remaining easy to operate.</p>

<p>The testing procedure setup is significantly simplified by the automatic fine-tuning function for the optimal probe frequency implemented in the Tomographic UD4-TM. To reduce labor intensity and improve testing reliability, Tomographic 2.5 supports devices that track the probe movement path, including tomographic scanners and other equipment.</p>

<p>Key software features:</p>

<ul>
    <li>Signal display in the complex plane and time-base sweep of signal projections;</li>
    <li>Archive for up to 500 settings and 1,000 flaw images;</li>
    <li>Testing of rough and unmachined surfaces;</li>
    <li>Evaluation of flaw depth and length;</li>
    <li>Visualization of the scanning path and graphical prompts.</li>
</ul>

<p>Test results are documented using the universal NDT Operator AWS application, which is included in the standard delivery package.</p>

<p>The training video supplied with the testing procedure demonstrates the complete testing process in accordance with RD 32.150-2000. It can be viewed both on a PC and directly on the flaw detector.</p>
HTML,
        ],
        'purpose' => 'railway',
        'image' => 'apps/tomographic-5m/2.5/thumb.webp',
        'images' => [
            'apps/tomographic-5m/2.5/1.webp',
            'apps/tomographic-5m/2.5/2.webp',
            'apps/tomographic-5m/2.5/3.webp',
            'apps/tomographic-5m/2.5/4.webp',
        ],
    ],
    [
        'version' => '2.6',
        'name' => [
            'ru' => 'Томографик 2.6 — ТИ 07.47-2005, ТИ 07.22-2000',
            'en' => 'Tomographic 2.6 — PS 07.47-2005, PS 07.22-2000',
        ],
        'short_description' => [
            'ru' => 'Железнодорожное приложение «Томографик 2.6» разработано для приемочного и эксплуатационного контроля сварных рельсовых стыков в пути или на РСП. Приложение предназначено для работы с соединениями, выполненными методом алюминотермитной и электроконтактной сварки, в соответствии с СТО РЖД 1.11.003-2009. Также оно применяется для контроля швов крестовин стрелочных переводов согласно техническим требованиям СТО РЖД 1.11.007-2009. Приложение может использоваться для выборочного и подтверждающего неразрушающего контроля (вторичного контроля). Рекомендовано ОАО «РЖД» к применению на пространстве 1520 мм. Является современным средством диагностики и мониторинга, обеспечивающим контроль сварных стыков по всему сечению рельса, включая головку, шейку и подошву.',
            'en' => 'Railway application Tomographic 2.6 is designed for acceptance and operational testing of welded rail joints on track or in the rail-welding machine. This application is intended to handle joints performed by the method of alumino-thermal or electric-contact welding in accordance with RZD Industry Standard 1.11.003-2009. It is also applied for testing of point frog seams under the technical requirements of RZD Industry Standard 1.11.007-2009. It can be used for sample or confirmatory nondestructive testing (secondary testing). It is recommended by OJSC RZD for application across the 1520 mm gauge network and serves as a modern diagnostic and monitoring tool that ensures testing of welded joints across the entire rail section, including the head, web and base.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h2>Томографик 2.6, ТИ 07.47-2005, ТИ 07.22-2000</h2>

<p>Железнодорожное приложение «Томографик 2.6» разработано для приемочного и эксплуатационного контроля сварных рельсовых стыков в пути или на РСП. Приложение предназначено для работы с соединениями, выполненными методом алюминотермитной и электроконтактной сварки, в соответствии с СТО РЖД 1.11.003-2009. Также оно применяется для контроля швов крестовин стрелочных переводов согласно техническим требованиям СТО РЖД 1.11.007-2009. Приложение может использоваться для выборочного и подтверждающего неразрушающего контроля (вторичного контроля). Рекомендовано ОАО «РЖД» к применению на пространстве 1520 мм. Является современным средством диагностики и мониторинга, обеспечивающим контроль сварных стыков по всему сечению рельса, включая головку, шейку и подошву.</p>

<p>Автоматизация процессов контроля и формирования протоколов достигается благодаря применению координатных устройств «Тандем», «Видеоскоп», «Слайдер М3» и «Слайдер М4» (стационарный вариант исполнения «Слайдера М3» для РСП).</p>

<p>Преимущества ПО «Томографик 2.6»:</p>

<ul>
    <li>Определение параметров преобразователя с помощью стандартного образца СО-3Р;</li>
    <li>Возможность формирования A-, B- и C-разверток при подключении сканирующих устройств или A- и B(t)-разверток без их применения;</li>
    <li>Наличие функции «Отрыв», обеспечивающей слежение за контактом преобразователя с исследуемой поверхностью;</li>
    <li>Сохранение результатов контроля в базе данных в виде протокола, содержащего параметры диагностики: чувствительность, время исследования и характеристики пьезоэлектрического преобразователя;</li>
    <li>Возможность оценки опасных дефектов рельса непосредственно на месте проведения контроля.</li>
</ul>

<p>Мониторинг соблюдения регламента выполнения контроля осуществляется с помощью координатных устройств «Слайдер М3» и «Тандем» при проведении исследований в пути или «Слайдер М4» в условиях РСП. Оборудование отслеживает координаты перемещения преобразователя с учетом наличия акустического контакта.</p>

<p>По завершении контроля формируется протокол, содержащий информацию о параметрах проверки, сканы разверток, визуализацию расположения дефектов и их координаты. Просмотр отчета возможен как на экране прибора, так и с помощью компьютера.</p>

<h3>«Слайдер М3»</h3>

<p>Механическая система двухмерной привязки координат. Устройство применяется совместно с дефектоскопом УД4-ТМ/УД4-Т и предназначено для определения местоположения пьезоэлектрического преобразователя на исследуемом объекте, а также для отслеживания траектории его перемещения. Система позволяет контролировать полноту проверки, сохранять в режиме реального времени координаты обнаруженных дефектов, выполнять их графическое отображение и оценивать степень опасности.</p>

<p>«Слайдер М3» применяется в пути для диагностики сварных швов, выполненных методом алюминотермитной и электроконтактной сварки. Также устройство используется при проведении вторичного контроля. Перед началом работ устройство устанавливается на головку рельса и закрепляется с помощью магнитов.</p>

<p>Преимущества системы «Слайдер М3»:</p>

<ul>
    <li>Возможность использования при локальной проверке состояния рельсов в пути;</li>
    <li>Контроль полноты проверки по всей поверхности объекта;</li>
    <li>Формирование отчета на основании дефектограмм по всему сечению рельса, включая головку, шейку и подошву;</li>
    <li>Автоматическое определение условных размеров дефектов.</li>
</ul>

<p>На экране под A-разверткой отображается B(x)-развертка — суммарное изображение серии B-разверток. Их наложение выполняется с учетом направления сканирования относительно стыка. В нижней части экрана отображается C(x,z)-развертка, разделенная на ячейки.</p>

<p>Каждой ячейке C(x,z)-развертки соответствует прямая или ломаная линия на B(x)-развертке. При регистрации эхосигналов, превышающих порог АСД, ячейки окрашиваются в зеленый, желтый, оранжевый или красный цвет. Цветовая градация отражает увеличение амплитуды сигнала в соответствующей ячейке.</p>

<h3>«Слайдер М4»</h3>

<p>Усовершенствованная версия устройства «Слайдер М3», предназначенная для использования в условиях РСП. Отличительной особенностью является отсутствие необходимости устанавливать устройство непосредственно на рельс. Также поддерживается возможность записи нижней поверхности подошвы в виде B- и C-разверток.</p>

<p>«Слайдер М4» представляет собой сканирующее устройство на стационарной раме, требующей крепления к полу. При соблюдении требований СТО РЖД 1.11.003-2009, регламентирующих контроль стыков, допустимая зона остановки сварного шва составляет 320 мм в продольном и 40 мм в поперечном направлении. Регистрация результатов диагностики выполняется по всему сечению рельса благодаря возможности вращения перекладины вокруг осей.</p>

<p>Преимущества системы «Слайдер М4»:</p>

<ul>
    <li>Применение при проверке состояния рельсов на РСП;</li>
    <li>Контроль полноты проверки по всей поверхности объекта;</li>
    <li>Возможность записи нижней поверхности подошвы в виде B- и C-разверток, в отличие от «Слайдера М3»;</li>
    <li>Отсутствие необходимости установки устройства на рельс и снятия с него;</li>
    <li>Автоматическое формирование отчета по результатам контроля на основании дефектограмм всего сечения рельса, включая головку, шейку и подошву;</li>
    <li>Автоматическое определение условных размеров дефектов.</li>
</ul>

<p>Рельсовый дефектоскоп «Томографик» УД4-ТМ оснащен GPS-приемником, позволяющим привязывать местоположение каждого стыка к географическим координатам. Работа оператора сводится к правильной установке сканеров, выбору необходимого приложения из пакета встроенного программного обеспечения и выделению на экране устройства выбранной зоны контроля.</p>

<p>Отрисовка на дисплее осуществляется в режиме реального времени, что позволяет определять расположение дефектных участков, а также участков, на которых отсутствовал контакт ПЭП с рельсом. При проведении контроля возможно штатное подключение дополнительных сканеров моделей «Тандем» и «Видеоскоп».</p>

<h3>«Видеоскоп»</h3>

<p>Устройство представляет собой портативную видеокамеру, установленную на телескопическом штативе. Оно предназначено для выявления дефектов по коду 53.1 без снятия накладок, а также по коду 69 без использования зеркал. Видеосканер применяется при выборочном визуальном контроле элементов верхнего строения пути и болтовых отверстий рельса.</p>

<p>Проверка с помощью данного устройства позволяет включать в итоговые протоколы изображения дефектных зон с указанием их реальных размеров. Подключение видеосканера осуществляется через разъем Scanner на боковой панели дефектоскопа. Устройство может работать параллельно с основным каналом неразрушающего контроля: вихретоковым, ультразвуковым, электромагнитоакустическим и другими. Изображение при этом выводится на дисплей устройства УД4-ТМ.</p>

<h3>«Тандем»</h3>

<p>Представляет собой сканерную каретку, предназначенную для контроля поверхности катания поперечного сварного соединения. Контроль выполняется с помощью двух наклонных пьезоэлектрических преобразователей с углом ввода 45° по зеркальному методу.</p>

<p>Применение дефектоскопа УД4-ТМ с устройством «Тандем» обеспечивает возможность сканирования объектов с заданным шагом и сохранения в памяти координат обнаруженных дефектов. Прибор также позволяет строить в режиме реального времени B-развертки поперечного шва в области головки, шейки и ее проекции на подошву. Это сокращает время проведения контроля и позволяет расшифровывать полученные данные непосредственно с прибора.</p>

<h3>«АРМ Дефектоскописта»</h3>

<p>Программное приложение для ПК предназначено для передачи базы данных протоколов контроля с прибора неразрушающего контроля на компьютер. Оно также используется для подготовки и печати результатов проверок с изображениями обнаруженных дефектов. Кроме того, программа предоставляет возможность ведения баз данных о состоянии контролируемых объектов.</p>
HTML,
            'en' => <<<'HTML'
<h1>Tomographic 2.6, PS 07.47-2005, PS 07.22-2000</h1>

    <p>Railway application Tomographic 2.6 is designed for acceptance and operational testing of welded rail joints on track or in the rail-welding machine. This application is intended to handle joints performed by the method of alumino-thermal or electric-contact welding in accordance with RZD Industry Standard 1.11.003-2009. It is also applied for testing of point frog seams under the technical requirements of RZD Industry Standard 1.11.007-2009. It can be used for sample or confirmatory nondestructive testing (secondary testing). It is recommended by OJSC RZD for application across the 1520 mm gauge network and serves as a modern diagnostic and monitoring tool that ensures testing of welded joints across the entire rail section, including the head, web and base.</p>

    <p>Automation of testing and report generation is achieved through the use of coordinate devices «Tandem», «Videoscop», «Slider M3» and «Slider M4» (a stationary version of Slider M3 for rail-welding facilities).</p>

    <p>Advantages of the Tomographic 2.6 application:</p>

    <ul>
        <li>Determination of probe parameters using the SO-3R calibration block;</li>
        <li>Ability to generate A-, B- and C-scans when scanning devices are connected, or A- and B(t)-scans without them;</li>
        <li>Availability of the “Disengagement” function, which monitors probe contact with the examined surface;</li>
        <li>Storage of test results in a database in the form of a report containing diagnostic parameters, including sensitivity, examination time and piezoelectric probe characteristics;</li>
        <li>Ability to assess dangerous rail flaws directly on site.</li>
    </ul>

    <p>Testing procedures are monitored using the coordinate devices «Slider M3» and «Tandem» for testing on track, or «Slider M4» in rail-welding facilities. The equipment tracks the probe movement coordinates while taking acoustic contact into account.</p>

    <p>Upon completion of testing, a report is generated containing test parameters, scan images, and visual representations of flaw locations and coordinates. The report can be viewed both on the instrument screen and on a computer.</p>

    <h2>Slider M3</h2>

    <p>Slider M3 is a mechanical two-dimensional coordinate referencing system designed for use with the UD4-TM/UD4-T flaw detector. It determines the position of the piezoelectric probe on the tested object and tracks its movement path. The system makes it possible to monitor testing coverage, record the coordinates of detected flaws in real time, display them graphically and assess their hazard level.</p>

    <p>Slider M3 is used on track to inspect joints produced by alumino-thermal or electric-contact welding. It is also used during secondary testing. Before work begins, the device is installed on the rail head and secured with magnets.</p>

    <p>Advantages of the Slider M3 system:</p>

    <ul>
        <li>Can be used for local inspection of rail condition on track;</li>
        <li>Monitors testing coverage across the entire surface of the tested object;</li>
        <li>Generates reports based on defectograms covering the entire rail section, including the head, web and base;</li>
        <li>Automatically determines the conventional dimensions of flaws.</li>
    </ul>

    <p>Below the A-scan, the screen displays the B(x)-scan, which represents a combined image of a series of B-scans. The B-scans are superimposed according to the scanning direction relative to the joint. The lower part of the screen displays the C(x,z)-scan, which is divided into cells.</p>

    <p>Each cell of the C(x,z)-scan corresponds to a straight or broken line on the B(x)-scan. When echo signals exceeding the automatic flaw signaling threshold are detected, the cells are colored green, white, orange or red. The color gradation indicates an increase in signal amplitude in the corresponding cell.</p>

    <h2>Slider M4</h2>

    <p>Slider M4 is an upgraded version of Slider M3 designed for use in rail-welding facilities. It eliminates the need to install the device directly on the rail. It also supports recording the bottom of the rail base in the form of B- and C-scans.</p>

    <p>Slider M4 is a scanning device mounted on a stationary frame secured to the floor. When the requirements of RZD Industry Standard 1.11.003-2009 governing joint testing are met, the permissible weld stopping zone is 320 mm in the longitudinal direction and 40 mm in the transverse direction. Diagnostic results are recorded across the entire rail section thanks to the ability to rotate the crossbar around its axes.</p>

    <p>Advantages of the Slider M4 system:</p>

    <ul>
        <li>Used for inspecting rail condition in rail-welding facilities;</li>
        <li>Monitors testing coverage across the entire surface of the tested object;</li>
        <li>Unlike Slider M3, allows the bottom of the rail base to be recorded as B- and C-scans;</li>
        <li>Eliminates the need to install the device on the rail and remove it afterwards;</li>
        <li>Automatically generates test reports based on defectograms covering the entire rail section, including the head, web and base;</li>
        <li>Automatically determines the conventional dimensions of flaws.</li>
    </ul>

    <p>The Tomographic UD4-TM rail flaw detector is equipped with a GPS receiver that allows the location of each joint to be referenced to geographical coordinates. The operator's tasks are limited to correctly installing the scanners, selecting the required application from the built-in software package and marking the selected testing area on the device screen.</p>

    <p>Rendering on the display is performed in real time, making it possible to identify defective areas as well as areas where there was no contact between the piezoelectric probe and the rail. During testing, additional scanners of the Tandem and Videoscop models can also be connected to the instrument.</p>

    <h2>Videoscop</h2>

    <p>This device is a portable video camera mounted on a telescopic tripod. It is designed to detect flaws under code 53.1 without removing fishplates, as well as flaws under code 69 without using mirrors. The video scanner is used for selective visual inspection of track superstructure components and rail bolt holes.</p>

    <p>Testing with this device makes it possible to include images of defective areas with their actual dimensions in the final reports. The video scanner is connected through the Scanner connector on the side panel of the flaw detector. It can operate in parallel with the main nondestructive testing channel, including eddy-current, ultrasonic and electromagnetic-acoustic testing. The image is displayed on the UD4-TM screen.</p>

    <h2>Tandem</h2>

    <p>Tandem is a scanning carriage designed to inspect the running surface of a transverse welded joint. The process is performed using two angled piezoelectric probes with a 45-degree angle, employing the mirror method.</p>

    <p>Using the UD4-TM flaw detector together with the Tandem device makes it possible to scan objects at the required scanning interval and store the coordinates of detected flaws in memory. The instrument also generates real-time B-scans of the transverse weld in the rail head and web areas, as well as its projection into the base. This reduces testing time and allows the acquired data to be analyzed using the instrument.</p>

    <h2>NDT Operator AWS</h2>

    <p>This PC application is used to transfer databases of test reports from the nondestructive testing instrument to a computer. It is also used to prepare and print test results together with images of detected flaws. In addition, the software makes it possible to maintain databases containing information about the condition of tested objects.</p>
HTML,
        ],
        'purpose' => 'railway',
        'image' => 'apps/tomographic-5m/2.6/thumb.webp',
        'images' => [
            'apps/tomographic-5m/2.6/1.webp',
            'apps/tomographic-5m/2.6/2.webp',
            'apps/tomographic-5m/2.6/3.webp',
            'apps/tomographic-5m/2.6/4.webp',
        ],
    ],
    [
        'version' => '2.7',
        'name' => [
            'ru' => 'Томографик 2.7 — ВТК деталей локомотивов и МВПС',
            'en' => 'Tomographic 2.7 — Eddy-Current Testing of Locomotive and MDRS Parts',
        ],
        'short_description' => [
            'ru' => 'Специализированное программное обеспечение Томографик 2.7 предназначено для вихретокового контроля деталей локомотивов и моторвагонного подвижного состава (МВПС) при всех видах их планового ремонта в депо и на заводах.',
            'en' => 'Specialized software Tomographic 2.7 is intended for eddy-current testing of locomotive and motor-driven rolling stock (MDRS) parts during all types of scheduled maintenance and repair at railway depots and factories.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h1>Томографик 2.7, ВТК деталей локомотивов и МВПС</h1>

<p>Специализированное программное обеспечение Томографик 2.7 предназначено для вихретокового контроля деталей локомотивов и моторвагонного подвижного состава (МВПС) при всех видах их планового ремонта в депо и на заводах.</p>

<p>Наглядность восприятия результатов контроля достигается за счет представления сигнала в виде столбиковой диаграммы, вектора или маркера на комплексной плоскости. В программе предусмотрен анализ годографа сигнала, что улучшает выявление сигнала от дефектов на фоне помех.</p>

<p>Для снижения влияния человеческого фактора на результаты контроля в программе реализовано фоновое слежение за действиями оператора, отстройка от наклона и зазора преобразователя на объекте контроля.</p>

<p>Совместно с методикой ВТК также используется сканирующее устройство УСК-ТЛ, которое имеет встроенный вихретоковый датчик для выявления заводских клеймений бандажей с целью недопущения перебраковки (ложного срабатывания дефектов в зоне клеймений). Благодаря встроенной многоканальной системе УЗ- и ВТ-датчики работают одновременно.</p>

<p>Данные хранятся в архиве прибора в виде протоколов с возможностью их предварительного просмотра. Программное приложение Томографик 2.7 предусматривает статистическую обработку и сортировку данных по задаваемому оператором критерию. Передача данных из прибора на компьютер выполняется посредством Windows-приложения «АРМ дефектоскописта».</p>

<h2>Характерные особенности ПО</h2>

<ul>
<li>Отображение сигнала в комплексной плоскости и временная развертка проекций сигнала.</li>
<li>Архив до 500 настроек и 1000 изображений дефектов.</li>
<li>Контроль грубых и необработанных поверхностей.</li>
<li>Оценка глубины и протяженности дефекта.</li>
<li>Визуализация траектории сканирования и графических подсказок.</li>
<li>Архив результатов позволяет просмотреть всю требуемую информацию о параметрах и результатах контроля. Документирование результатов контроля осуществляется посредством универсального приложения.</li>
</ul>
HTML,
            'en' => <<<'HTML'
<h1>Tomographic 2.7, Eddy-Current Testing of Locomotive and MDRS Parts</h1>

<p>Specialized software Tomographic 2.7 is intended for eddy-current testing of locomotive and motor-driven rolling stock (MDRS) parts during all types of scheduled maintenance and repair at railway depots and factories.</p>

<p>Clear visualization of test results is achieved by presenting the signal as a bar chart, vector, or marker on the complex plane. The software provides signal hodograph analysis, improving the detection of flaw signals against background noise.</p>

<p>To reduce the influence of human factors on test results, the software implements background monitoring of operator actions and compensation for probe inclination and lift-off from the tested surface.</p>

<p>The eddy-current testing procedure also uses the USK-TL scanning device, which incorporates a built-in eddy-current probe for detecting manufacturer’s markings on wheel tires and preventing unnecessary rejection due to false flaw indications in marked areas. The built-in multichannel system enables ultrasonic and eddy-current probes to operate simultaneously.</p>

<p>Data is stored in the instrument’s archive as reports that can be previewed. The Tomographic 2.7 software application supports statistical processing and sorting of data according to criteria specified by the operator. Data is transferred from the instrument to a computer using the Windows application “NDT Operator AWS”.</p>

<h2>Software Features</h2>

<ul>
<li>Signal display on the complex plane and time-domain sweeps of signal projections.</li>
<li>Archive supporting up to 500 settings and 1,000 flaw images.</li>
<li>Testing of rough and unmachined surfaces.</li>
<li>Evaluation of flaw depth and length.</li>
<li>Visualization of the scanning path and graphical prompts.</li>
<li>Results archive providing access to all required information on test parameters and results. Test results are documented using the universal software application.</li>
</ul>
HTML,
        ],
        'purpose' => 'railway',
        'image' => 'apps/tomographic-5m/2.7/thumb.webp',
        'images' => [
            'apps/tomographic-5m/2.7/1.webp',
            'apps/tomographic-5m/2.7/2.webp',
            'apps/tomographic-5m/2.7/3.webp',
            'apps/tomographic-5m/2.7/4.webp',
        ],
    ],
    [
        'version' => '2.8',
        'name' => [
            'ru' => 'Томографик 2.8 — ПР НК В.2-2013',
            'en' => 'Tomographic 2.8 — NDT Regulations V.2-2013',
        ],
        'short_description' => [
            'ru' => 'Приложение «Томографик 2.8» реализует комплексный ультразвуковой контроль колесных пар грузовых вагонов в соответствии с требованиями ПР НК В.2 «Правила неразрушающего контроля деталей и составных частей колесных пар вагонов при ремонте. Специальные требования», утвержденных 59-м заседанием Совета по железнодорожному транспорту государств — участников Содружества (протокол заседания от 19–20 ноября 2013 г. № 59), с учетом изменений и дополнений, утвержденных на заседании Совета по железнодорожному транспорту государств — участников Содружества (протокол заседания от 4–5 ноября 2015 г. № 63, п. 7), а также ТИ НК В.21-1, разработанной на основании ПР НК В.2.',
            'en' => 'Application “Tomographic 2.8” implements comprehensive ultrasonic testing of freight wagon wheelsets in accordance with the requirements of NDT Regulations V.2, “Rules for Non-Destructive Testing of Parts and Components of Wagon Wheelsets During Repair. Special Requirements,” approved at the 59th meeting of the Railway Transport Council of the Commonwealth Member States (Minutes No. 59, November 19–20, 2013), as amended and supplemented by the Council’s decision at its 63rd meeting (Minutes No. 63, Item 7, November 4–5, 2015), and NDT Procedure V.21-1, developed on the basis of NDT Regulations V.2.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h1>Томографик 2.8, ПР НК В.2-2013</h1>

<p>Приложение «Томографик 2.8» реализует комплексный ультразвуковой контроль колесных пар грузовых вагонов в соответствии с требованиями ПР НК В.2 «Правила неразрушающего контроля деталей и составных частей колесных пар вагонов при ремонте. Специальные требования», утвержденных 59-м заседанием Совета по железнодорожному транспорту государств — участников Содружества (протокол заседания от 19–20 ноября 2013 г. № 59), с учетом изменений и дополнений, утвержденных на заседании Совета по железнодорожному транспорту государств — участников Содружества (протокол заседания от 4–5 ноября 2015 г. № 63, п. 7), а также ТИ НК В.21-1, разработанной на основании ПР НК В.2.</p>

<h2>Специализированная методика «Томографик 2.8» предусматривает:</h2>

<ul>
<li>Ручной УЗК осей колесных пар типов РУ1 и РУ1Ш по обязательным вариантам методов AR1.1, AR1.2, AR1.3, AR2, AR3, AR3.1, TR2 и по дополнительным вариантам методов AR4, TR1.</li>
<li>Ручной УЗК осей колесных пар типа РВ2Ш по обязательным вариантам методов AR1.2, AR1.5, AR2, AR3, AR3.1, TR2 и по дополнительным вариантам методов AR4, TR1.</li>
<li>Механизированный УЗК осей колесных пар типов РУ1, РУ1Ш и РВ2Ш по обязательным вариантам методов BR1, BR2, BR3, BR4.</li>
<li>Механизированный УЗК цельнокатаных колес колесных пар по обязательным вариантам методов DR2.1, DR2.2, DR3.1, DR3.3 и по дополнительному варианту метода WR.</li>
<li>Ручной УЗК цельнокатаных колес колесных пар по обязательному варианту метода DR4.</li>
</ul>

<p>Механизированный ультразвуковой контроль цельнокатаных колес выполняется с применением сканирующего устройства УСК-5ТМ и обеспечивает контроль необходимых зон за один поворот с возможностью построения томографических изображений и определения координат дефектного участка.</p>

<p>При необходимости сканер УСК-5ТМ комплектуется вихретоковым датчиком для выявления заводских клеймений с целью предотвращения перебраковки колес, вызванной ложными срабатываниями в зоне клеймений. Благодаря встроенной многоканальной системе ультразвуковой и вихретоковый датчики работают одновременно.</p>

<p>Механизированный контроль осей колесных пар с применением сканирующих устройств УСО-1ТМ для ультразвукового контроля осей типов РУ1 и РУ1Ш и УСО-1РВ2Ш для контроля осей типа РВ2Ш проводится с предподступичной части. Он обеспечивает контроль необходимых зон за один поворот без демонтажа буксового узла, с возможностью построения томографических изображений и определения координат дефектного участка.</p>

<p>Для предварительной подготовки контролируемой поверхности и очистки от эксплуатационных загрязнений предлагается механический сканер очистки УОО-1Т со сменными кассетами (ножами).</p>

<p>При контроле цельнокатаных колес и осей колесных пар с применением сканирующих устройств УСК-5ТМ, УСО-1ТМ и УСО-1РВ2Ш на экране дефектоскопа отображается А-развертка текущей контролируемой зоны. При этом работают все пьезоэлектрические преобразователи (ПЭП), входящие в состав сканирующего устройства. Данные по всем ПЭП в процессе контроля, по мере перемещения устройства по объекту, отображаются на С-развертке.</p>

<h2>Функциональные возможности</h2>

<p>Концепция приложения «Томографик 2.8» ориентирована на максимальное снижение влияния человеческого фактора за счет реализации следующих функций:</p>

<ul>
<li>Автоматическая регулировка усиления, позволяющая сократить время подбора необходимого усиления в режиме настройки.</li>
<li>Автоматическое определение браковочного уровня и соотношения между браковочным уровнем соответствующего варианта метода и амплитудой эхо-сигнала от предусмотренного этим вариантом метода отражателя в настроечном образце (НО). Это необходимо для ежесменной проверки основных параметров УЗК с использованием НО.</li>
<li>Автоматическая настройка временной регулировки чувствительности (ВРЧ) при ультразвуковом контроле осей по вариантам методов AR2 и AR3.</li>
<li>Слежение за акустическим контактом.</li>
<li>Полный мониторинг ПЭП.</li>
<li>Автоматическая отстройка от структурных шумов.</li>
<li>Визуализация дефектов с отображением эквивалентной площади, глубины залегания и пространственной ориентации.</li>
</ul>

<h2>Документирование результатов контроля</h2>

<p>Специальная программа «АРМ Дефектоскописта ЖД», поставляемая вместе с дефектоскопом УД4-ТМ, позволяет документировать результаты контроля, сохранять их в электронной базе данных и формировать паспорт колесной пары.</p>

<p>Кроме того, в прибор встраиваются обучающие демонстрационные ролики по работе со специализированными приложениями, которые существенно упрощают ознакомление с прибором и его программным обеспечением.</p>
HTML,
            'en' => <<<'HTML'
<h1>Tomographic 2.8, NDT Regulations V.2-2013</h1>

<p>Application “Tomographic 2.8” implements comprehensive ultrasonic testing of freight wagon wheelsets in accordance with the requirements of NDT Regulations V.2, “Rules for Non-Destructive Testing of Parts and Components of Wagon Wheelsets During Repair. Special Requirements,” approved at the 59th meeting of the Railway Transport Council of the Commonwealth Member States (Minutes No. 59, November 19–20, 2013), as amended and supplemented by the Council’s decision at its 63rd meeting (Minutes No. 63, Item 7, November 4–5, 2015), and NDT Procedure V.21-1, developed on the basis of NDT Regulations V.2.</p>

<h2>Specialized Testing Procedures</h2>

<p>The “Tomographic 2.8” application supports the following procedures:</p>

<ul>
<li>Manual ultrasonic testing of RU1 and RU1Sh wheelset axles using the mandatory method variants AR1.1, AR1.2, AR1.3, AR2, AR3, AR3.1, and TR2, and the supplementary variants AR4 and TR1.</li>
<li>Manual ultrasonic testing of RV2Sh wheelset axles using the mandatory method variants AR1.2, AR1.5, AR2, AR3, AR3.1, and TR2, and the supplementary variants AR4 and TR1.</li>
<li>Mechanized ultrasonic testing of RU1, RU1Sh, and RV2Sh wheelset axles using the mandatory method variants BR1, BR2, BR3, and BR4.</li>
<li>Mechanized ultrasonic testing of solid-rolled wheelset wheels using the mandatory method variants DR2.1, DR2.2, DR3.1, and DR3.3, and the supplementary variant WR.</li>
<li>Manual ultrasonic testing of solid-rolled wheelset wheels using the mandatory method variant DR4.</li>
</ul>

<p>Mechanized ultrasonic testing of solid-rolled wheels is performed using the USK-5TM scanning device. It enables inspection of the required zones in a single revolution, with tomographic imaging and determination of flaw coordinates.</p>

<p>If required, the USK-5TM scanner can be equipped with an eddy-current probe to detect manufacturer’s markings and prevent unnecessary wheel rejection caused by false flaw indications in marked areas. The built-in multichannel system enables ultrasonic and eddy-current probes to operate simultaneously.</p>

<p>Mechanized ultrasonic testing of wheelset axles is performed using the USO-1TM scanning device for RU1 and RU1Sh axles and the USO-1RV2Sh device for RV2Sh axles. Testing is carried out in the area ahead of the wheel seat, allowing the required zones to be inspected in a single revolution without dismantling the axlebox. Tomographic imaging and determination of flaw coordinates are also supported.</p>

<p>For preliminary preparation of the test surface and removal of operational contamination, the UOO-1T mechanical cleaning scanner with replaceable cartridges (blades) is available.</p>

<p>During ultrasonic testing of solid-rolled wheels and wheelset axles using the USK-5TM, USO-1TM, and USO-1RV2Sh scanning devices, the flaw detector displays the A-scan of the current inspection zone. All piezoelectric probes (PEPs) incorporated into the scanning device operate simultaneously. Data from all probes is displayed on the C-scan as the device moves across the inspected object.</p>

<h2>Functional Capabilities</h2>

<p>The “Tomographic 2.8” application is designed to minimize human error through the following functions:</p>

<ul>
<li>Automatic gain control, reducing the time required to select the appropriate gain during setup.</li>
<li>Automatic determination of the rejection threshold and calculation of the relationship between the rejection threshold for a given method variant and the echo-signal amplitude from the corresponding reference reflector in the reference block. This supports daily verification of the main ultrasonic testing parameters using the reference block.</li>
<li>Automatic distance-amplitude correction (DAC) adjustment for axle testing using method variants AR2 and AR3.</li>
<li>Acoustic contact monitoring.</li>
<li>Comprehensive PEP monitoring.</li>
<li>Automatic suppression of structural noise.</li>
<li>Flaw visualization, including equivalent area, depth, and spatial orientation.</li>
</ul>

<h2>Test Results Documentation</h2>

<p>The specialized “Railway NDT Operator AWS” software supplied with the Tomographic UD4-TM flaw detector enables test results to be documented, stored in an electronic database, and used to generate a wheelset certificate.</p>

<p>Training demonstration videos covering the specialized applications are also preloaded into the instrument, significantly simplifying familiarization with the equipment and its software.</p>
HTML,
        ],
        'purpose' => 'railway',
        'image' => null,
        'images' => [
        ],
    ],
    [
        'version' => '2.9',
        'name' => [
            'ru' => 'Томографик 2.9 — СТО РЖД 1.11.002-2008',
            'en' => 'Tomographic 2.9 — RZD Industry Standard 1.11.002-2008',
        ],
        'short_description' => [
            'ru' => 'Приложение «Томографик 2.9» реализует комплексный ультразвуковой контроль колесных пар грузовых вагонов в соответствии с требованиями СТО РЖД 1.11.002-2008 «Контроль неразрушающий. Элементы колесных пар вагонов. Технические требования к ультразвуковому контролю».',
            'en' => 'Application "Tomographic 2.9" implements the combined ultrasonic testing of wheel sets of cargo vehicles in accordance with requirements of the RZD Industry Standard 1.11.002-2008 "Nondestructive testing. Elements of vehicle wheel sets. Technical specifications of ultrasonic testing".',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h1>Томографик 2.9, СТО РЖД 1.11.002-2008</h1>

<p>Приложение «Томографик 2.9» реализует комплексный ультразвуковой контроль колесных пар грузовых вагонов в соответствии с требованиями СТО РЖД 1.11.002-2008 «Контроль неразрушающий. Элементы колесных пар вагонов. Технические требования к ультразвуковому контролю».</p>

<h2>Специализированная методика «Томографик 2.9» предусматривает:</h2>

<ul>
<li>Ручной УЗК осей колесных пар по обязательным вариантам методов AR1.1, AR1.2, AR1.3, AR2, AR3, AR3.1, TR2 и по дополнительным вариантам методов AR1.4, AR4, TR1.</li>
<li>Механизированный УЗК осей колесных пар по обязательным вариантам методов BR1, BR2, BR3, BR4.</li>
<li>Механизированный УЗК цельнокатаных колес колесных пар по обязательным вариантам методов DR1.1, DR2.1, DR2.2, DR3.1, DR3.3 и по дополнительным вариантам методов DR1.2, DR3.2, WR.</li>
<li>Ручной УЗК цельнокатаных колес колесных пар по обязательному варианту метода DR4.</li>
</ul>

<p>Механизированный ультразвуковой контроль цельнокатаных колес выполняется с применением сканирующего устройства УСК-5ТМ и обеспечивает контроль необходимых зон за один поворот с возможностью построения томографических изображений и определения координат дефектного участка.</p>

<p>При необходимости сканер УСК-5ТМ комплектуется вихретоковым датчиком для выявления заводских клеймений с целью предотвращения перебраковки колес, вызванной ложными срабатываниями в зоне клеймений. Благодаря встроенной многоканальной системе ультразвуковой и вихретоковый датчики работают одновременно.</p>

<p>Механизированный контроль осей колесных пар с применением сканирующего устройства УСО-1ТМ проводится с предподступичной части и обеспечивает контроль необходимых зон за один поворот без демонтажа буксового узла, с возможностью построения томографических изображений и определения координат дефектного участка.</p>

<p>Для предварительной подготовки контролируемой поверхности и очистки от эксплуатационных загрязнений предлагается механический сканер очистки УОО-1Т со сменными кассетами (ножами).</p>

<p>При контроле цельнокатаных колес и осей колесных пар с применением сканирующих устройств УСК-5ТМ и УСО-1ТМ на экране дефектоскопа отображается А-развертка текущей контролируемой зоны. При этом работают все пьезоэлектрические преобразователи (ПЭП), входящие в состав сканирующего устройства. Данные по всем ПЭП в процессе контроля, по мере перемещения устройства по объекту контроля, отображаются на С-развертке.</p>

<h2>Функциональные возможности</h2>

<p>Концепция приложения «Томографик 2.9» ориентирована на максимальное снижение влияния человеческого фактора за счет реализации следующих функций:</p>

<ul>
<li>Автоматическая регулировка усиления, позволяющая сократить время подбора необходимого усиления.</li>
<li>Слежение за акустическим контактом.</li>
<li>Полный мониторинг ПЭП.</li>
<li>Автоматическая отстройка от структурных шумов.</li>
<li>Визуализация дефектов с отображением эквивалентной площади, глубины залегания и пространственной ориентации.</li>
</ul>

<h2>Документирование результатов контроля</h2>

<p>Специальная программа «АРМ Дефектоскописта ЖД», поставляемая вместе с дефектоскопом УД4-ТМ, позволяет документировать результаты контроля, сохранять их в электронной базе данных и формировать паспорт колесной пары.</p>

<p>Кроме того, в прибор встраиваются обучающие демонстрационные ролики по работе со специализированными приложениями, которые существенно упрощают ознакомление с прибором и его программным обеспечением.</p>
HTML,
            'en' => <<<'HTML'
<h1>Tomographic 2.9, RZD Industry Standard 1.11.002-2008</h1>

<p>Application "Tomographic 2.9" implements the combined ultrasonic testing of wheel sets of cargo vehicles in accordance with requirements of the RZD Industry Standard 1.11.002-2008 "Nondestructive testing. Elements of vehicle wheel sets. Technical specifications of ultrasonic testing".</p>

<p>Specialized procedure "Tomographic 2.9" provides the following:</p>

<ul>
<li>manual ultrasonic testing of wheel set axles under “mandatory” versions of method AR1.1, AR1.2, AR1.3, AR2, AR3, AR3.1, TR2 and “supplementary” versions of method AR1.4, AR4, TR1;</li>
<li>mechanized ultrasonic testing of wheel set axles under “mandatory” versions of method BR1, BR2, BR3, BR4;</li>
<li>mechanized ultrasonic testing of wrought wheels of wheel sets under “mandatory” versions of method DR1.1, DR2.1, DR2.2, DR3.1, DR3.3 and “supplementary” versions of method DR1.2, DR3.2, WR;</li>
<li>manual ultrasonic testing of wrought wheels of wheel sets under “mandatory” version of method DR4.</li>
</ul>

<p>Mechanized ultrasonic testing of wrought wheels is performed using scanning device USK-5TM and ensures control of required zones for a single revolution, with the possibility of tomographic imaging and determination of coordinates of the defective area.</p>

<p>If required, scanner USK-5TM is equipped with an eddy-current probe to reveal manufacturer’s marks in order to prevent over-rejection of wheels (false flaw responses in the marking area). Due to the built-in multi-channel system, ultrasonic and eddy-current probes operate simultaneously.</p>

<p>Mechanized ultrasonic testing of wheel set axles using scanning device USO-1TM is performed starting from the part ahead of the wheel seat. It ensures control of the required zones in a single revolution without dismantling the axle box, with the possibility of tomographic imaging and determination of coordinates of the defective area. For preliminary preparation of the tested surface (cleaning from operational contamination), a mechanical cleaning scanner UOO-1T with replaceable cartridges (blades) is offered to the user.</p>

<p>During ultrasonic testing of wrought wheels and wheel set axles using scanning devices USK-5TM and USO-1TM, the A-scan of the current zone is displayed on the flaw detector screen, with all probes included in the scanning device operating simultaneously. Data from all probes during testing (movement of the device over the test object) is displayed on the C-scan.</p>

<p>The concept of the "Tomographic 2.9" application is aimed at minimizing the influence of the human factor through the implementation of the following functions:</p>

<ul>
<li>automatic gain control, eliminating the need to spend time selecting the required gain;</li>
<li>acoustic contact monitoring;</li>
<li>full probe monitoring;</li>
<li>automatic suppression of structural noise;</li>
<li>visualization of flaws, including equivalent area, depth and spatial orientation.</li>
</ul>

<p>The specialized software "Railway NDT Operator AWS", supplied with the Tomographic UD4-TM flaw detector, enables documentation of test results, storage in an electronic database and generation of a wheel set certificate. Training demonstration videos covering the operation of specialized applications are also pre-installed in the instrument, significantly simplifying familiarization with the device.</p>
HTML,
        ],
        'purpose' => 'railway',
        'image' => null,
        'images' => [
        ],
    ],
    [
        'version' => '3.1',
        'name' => [
            'ru' => 'Томографик 3.1 — Резонансный дефектоскоп',
            'en' => 'Tomographic 3.1 — Resonance Flaw Detector',
        ],
        'short_description' => [
            'ru' => 'Приложение для выявления расслоений в композитах и непроклеев в изделиях из склеенных металлических материалов резонансным методом.',
            'en' => 'An application for detecting delaminations in composites and unbonded areas in bonded metal components using the resonance method.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h1>Томографик 3.1, Резонансный дефектоскоп</h1>

<p>Приложение «Резонансный дефектоскоп» предназначено для контроля изделий с целью выявления расслоений в композитах и непроклеев в изделиях, склеенных из металлических материалов.</p>

<p>Программа работает в частотном диапазоне 0,2–1,0 МГц.</p>

<p>Предусмотрена возможность автоматической и ручной настройки прибора. Для настройки программы необходимо снять две АЧХ: для бездефектного участка контрольного образца и для дефектного участка. На основе этих данных программа автоматически определяет оптимальную частоту для выявления дефекта и отображает обе снятые АЧХ.</p>

<p>Также предусмотрена возможность ручной установки необходимых параметров: частоты генератора, количества повторений частоты, начала и ширины временного интервала анализируемого сигнала. При ручной настройке частоты или временного интервала анализируемого сигнала отображается А-скан.</p>

<p>Зона отсутствия дефекта задаётся программно в виде эллипса фиолетового цвета. Её положение устанавливается таким образом, чтобы при нахождении датчика на любом бездефектном участке контрольного образца курсор находился внутри неё.</p>

<p>Координаты и форма эллипса регулируются с помощью задания угла поворота, смещения вдоль оси, наклонённой под этим углом, а также значений ширины и толщины эллипса. Кроме того, можно настраивать чувствительность в широком диапазоне (рис. 2).</p>

<p>Выполненные настройки сохраняются в архиве прибора, что позволяет практически мгновенно приступить к работе. После загрузки настроек не требуется выполнять дополнительные операции: достаточно перемещать датчик по контролируемой поверхности и наблюдать за показаниями на экране.</p>

<h2>Функциональные возможности</h2>

<ul>
    <li>Автоматическая настройка по АЧХ для дефектного и бездефектного участков.</li>
    <li>Ручная корректировка настроек.</li>
    <li>Определение бездефектной зоны в форме эллипса.</li>
    <li>Настройка чувствительности в широком диапазоне.</li>
    <li>Наличие архива настроек и документирование результатов контроля с помощью приложения «АРМ Дефектоскописта».</li>
    <li>Быстрая установка рабочего режима.</li>
</ul>
HTML,
            'en' => <<<'HTML'
<h1>Tomographic 3.1, Resonance Flaw Detector</h1>

<p>The application "Resonance Flaw Detector" is intended for testing articles to detect delaminations in composite materials and areas of insufficient bonding in articles made of bonded metal materials.</p>

<p>The application operates within the frequency range of 0.2–1.0 MHz.</p>

<p>The instrument can be configured automatically or manually. To configure the application, two frequency response curves must be recorded: one for a defect-free area of the reference specimen and one for a defective area. Based on these data, the application automatically determines the optimal frequency for flaw detection and displays both recorded frequency response curves.</p>

<p>It is also possible to set the required parameters manually, including generator frequency, number of frequency repetitions, start point and width of the time interval used for signal analysis. An A-scan is displayed when the frequency or the analyzed signal time interval is adjusted manually.</p>

<p>The defect-free zone is defined in the software as a violet ellipse. Its position is set so that the cursor remains inside the ellipse when the probe is placed on any defect-free area of the reference specimen.</p>

<p>The coordinates and shape of the ellipse can be adjusted by specifying the rotation angle, displacement along the axis inclined at that angle, and the width and thickness of the ellipse. Sensitivity can also be adjusted over a wide range (Fig. 2).</p>

<p>All settings are saved in the instrument archive, allowing testing to begin almost immediately. After loading the settings, no additional operations are required: simply move the probe over the surface being tested and monitor the display.</p>

<h2>Functional Features</h2>

<ul>
    <li>Automatic setup based on frequency response curves for defective and defect-free areas.</li>
    <li>Manual adjustment of settings.</li>
    <li>Definition of a defect-free zone in the shape of an ellipse.</li>
    <li>Sensitivity adjustment over a wide range.</li>
    <li>Settings archive and documentation of test results using the NDT Operator AWS application.</li>
    <li>Quick setup of the operating mode.</li>
</ul>
HTML,
        ],
        'purpose' => 'avia',
        'image' => 'apps/tomographic-5m/3.1/thumb.webp',
        'images' => [
            'apps/tomographic-5m/3.1/1.webp',
            'apps/tomographic-5m/3.1/2.webp',
            'apps/tomographic-5m/3.1/3.webp',
            'apps/tomographic-5m/3.1/4.webp',
        ],
    ],
    [
        'version' => '3.2',
        'name' => [
            'ru' => 'Томографик 3.2 — Акустический тензометр',
            'en' => 'Tomographic 3.2 — Acoustic Tensometer',
        ],
        'short_description' => [
            'ru' => 'Приложение для контроля усилия затяжки резьбовых соединений методом акустической тензометрии.',
            'en' => 'An application for measuring the tightening force of threaded joints using acoustic tensometry.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h1>Томографик 3.2, Акустический тензометр</h1>

<h2>Метод акустоупругости для определения степени затяжки резьбовых соединений</h2>

<p>Специализированное приложение «Акустический тензометр» предназначено для контроля усилия затяжки резьбовых соединений со шпильками и болтами диаметром не менее 12 мм при соотношении длины к диаметру не более 7, изготовленных из сталей и титановых сплавов.</p>

<p>Контроль усилий затяжки производится методами акустической тензометрии, под которой понимается совокупность методов и средств контроля, основанных на измерении характеристик упругих волн, распространяющихся в среде. Практическая реализация этой методики находит широкое применение в авиакосмической и нефтегазовой промышленности для контроля равномерности натяжения резьбовых соединений и построения тензографического изображения.</p>

<p>Объектами контроля, как правило, являются узлы болтовых соединений на железнодорожном транспорте и металлургических заводах, цилиндры высокого давления ТЭЦ и АЭС, сосуды высокого давления нефтегазодобывающей промышленности, элементы реактивных двигателей космических аппаратов и другие изделия.</p>

<p>Томографик 3.2 реализует метод акустической (ультразвуковой) тензометрии, основанный на зависимости скорости (времени распространения) ультразвуковых колебаний в материалах от действующих в них механических напряжений. Расчёт действующей величины механических напряжений осуществляется на основе прецизионных измерений времени распространения ультразвуковых волн в материале контролируемого изделия эхо-методом.</p>

<p>Работа с Томографик 3.2 разделяется на два этапа: создание и сохранение в памяти прибора настройки на контролируемое соединение и непосредственно контроль соединения с последующим сохранением результатов. Если настройка на данное соединение была создана и сохранена ранее, первый этап сводится к загрузке этой настройки из памяти прибора.</p>

<p>Процесс создания настройки представляет собой ввод параметров соединения, для контроля которого она создаётся, а также параметров используемого пьезоэлектрического преобразователя (ПЭП). Параметры развёртки и стробов устанавливаются автоматически в зависимости от введённых параметров соединения, однако при необходимости могут быть скорректированы вручную.</p>

<p>В режиме ввода параметров соединения на экран выводится изображение болта (шпильки), а вводимый параметр подсвечивается. Это повышает наглядность выполняемых действий и упрощает процесс создания настройки.</p>

<p>Программа предназначена для контроля соединений, в состав которых входят болты (шпильки) одного типа, то есть одинакового размера и изготовленные из одного материала. Поэтому при создании настройки вводятся параметры только одного болта (шпильки), а параметры остальных элементов считаются идентичными параметрам первого.</p>

<p>Основным параметром используемого ПЭП, который необходимо ввести, является его частота. При контроле усилий затяжки соединений обычно используются ПЭП типа П111-5-К12-040. Параметры ПЭП могут быть введены вручную либо загружены из архива преобразователей.</p>

<h2>Режимы контроля соединений</h2>

<p>Контроль соединений может осуществляться в трёх режимах: сборка, разборка и перепроверка.</p>

<ul>
    <li><strong>Сборка.</strong> Сначала измеряется время распространения ультразвуковых колебаний в болтах (шпильках) в незатянутом состоянии. Затем производится затяжка соединения и измеряется время распространения ультразвуковых колебаний в затянутых болтах (шпильках).</li>
    <li><strong>Разборка.</strong> Сначала измеряется время распространения ультразвуковых колебаний в болтах (шпильках) в затянутом состоянии. Затем соединение ослабляется и измеряется время распространения ультразвуковых колебаний в незатянутых болтах (шпильках).</li>
    <li><strong>Перепроверка.</strong> Для соединения, которое уже подвергалось контролю, выполняется повторное измерение времени распространения ультразвуковых колебаний в затянутых болтах (шпильках) с целью мониторинга состояния. При этом результат предыдущего контроля автоматически загружается из памяти, если он был сохранён, либо вводится вручную.</li>
</ul>

<p>В режиме контроля на экране отображается диаграмма усилий, отражающая распределение напряжений в каждом болте (шпильке). Это позволяет добиться равномерной затяжки всех деталей соединения. Степень затяжки текущего контролируемого элемента отображается с помощью цветовой индикации. Результаты контроля также могут быть представлены в виде таблицы.</p>

<h2>Функциональные возможности</h2>

<ul>
    <li>Наглядный и удобный ввод параметров контролируемого соединения.</li>
    <li>Встроенная база данных акустических свойств различных материалов.</li>
    <li>Автоматическая установка стробов на донные эхо-сигналы.</li>
    <li>Автоматическая регулировка амплитуды донных эхо-сигналов.</li>
    <li>Расчёт действующих механических напряжений в кгс/мм² или МПа, а также усилий в тоннах силы (тс) для каждой детали соединения.</li>
    <li>Представление результатов контроля в табличном виде и в виде диаграммы напряжений (усилий), на которой степень затяжки отображается цветовой индикацией.</li>
    <li>Возможность повторного контроля ранее проверенного соединения с одновременным отображением на экране нескольких результатов контроля данного соединения.</li>
    <li>Просмотр результатов контроля как на приборе, так и на персональном компьютере.</li>
</ul>

<p>Методика акустической тензометрии прошла испытания на Выксунском металлургическом заводе (ОАО «ВМЗ», ЗАО «Объединённая металлургическая компания») и запатентована.</p>

<p>По заказу РОСАВИАКОСМОС для НПО «Энергомаш» имени академика В. П. Глушко были разработаны дополнительные программные и технические изменения в соответствии с ОСТ 92-9521. Эти дополнения к базовой версии Томографик 3.2 оформлены в виде отдельного специализированного приложения «АКОН-4М».</p>
HTML,
            'en' => <<<'HTML'
<h1>Tomographic 3.2, Acoustic Tensometer</h1>

<h2>Acoustoelasticity Method for Determining Screw Joint Tightness</h2>

<p>The specialized application “Acoustic Tensometer” is designed to measure the tightening force of bolted joints containing studs and bolts with a diameter of at least 12 mm and a length-to-diameter ratio not exceeding 7. The bolts and studs must be made of steel or titanium alloys.</p>

<p>Tightening forces are measured using acoustic tensometry, a set of testing methods and instruments based on measuring the characteristics of elastic waves propagating through a material. These techniques are widely used in the aerospace and oil and gas industries to monitor the uniformity of tension in bolted joints and generate tensographic images.</p>

<p>Typical test objects include bolted assemblies in railway vehicles and steelworks, high-pressure cylinders at thermal and nuclear power plants, pressure vessels in the oil and gas industry, and components of spacecraft jet engines.</p>

<p>Tomographic 3.2 implements acoustic (ultrasonic) tensometry, which is based on the relationship between mechanical stress in a material and the velocity or propagation time of ultrasonic waves. The effective mechanical stress is calculated from precision measurements of ultrasonic wave propagation time through the tested component using the pulse-echo method.</p>

<h2>Operating Procedure</h2>

<p>Operation with Tomographic 3.2 consists of two stages: creating and saving a configuration for the joint to be tested, followed by testing the joint and saving the results. If a configuration has already been created and saved, the first stage consists simply of loading it from the instrument's memory.</p>

<p>Creating a configuration involves entering the joint parameters and the specifications of the ultrasonic transducer (PEP). Sweep and gate parameters are configured automatically according to the entered joint specifications but can be adjusted manually if necessary. During parameter entry, an image of the bolt or stud is displayed on the screen, with the parameter currently being entered highlighted. This improves visibility and simplifies configuration.</p>

<p>The application is designed for joints containing bolts or studs of the same type, size, and material. Therefore, only one bolt or stud needs to be specified when creating a configuration; the remaining fasteners are assumed to have identical parameters.</p>

<p>The main transducer parameter that must be entered is its frequency. PEP type P111-5-K12-040 is commonly used for measuring joint tightening forces. Transducer parameters can be entered manually or loaded from the transducer archive.</p>

<h2>Testing Modes</h2>

<p>Joints can be tested in three modes: assembly, disassembly, and reverification.</p>

<h3>Assembly</h3>
<p>First, the ultrasonic wave propagation time is measured in the bolts or studs in the untightened state. The joint is then tightened, and the propagation time is measured again in the tightened state.</p>

<h3>Disassembly</h3>
<p>First, the ultrasonic wave propagation time is measured in the tightened bolts or studs. The joint is then loosened, and the propagation time is measured again in the untightened state.</p>

<h3>Reverification</h3>
<p>For a joint that has already been tested, the ultrasonic propagation time is measured again in the tightened bolts or studs to monitor their condition. The previous test results are loaded automatically from memory if available; otherwise, they can be entered manually.</p>

<h2>Displaying Test Results</h2>
<p>During testing, the screen displays a force diagram showing the stress distribution in each bolt or stud. This allows the operator to achieve uniform tightening across all components of the joint. The tightening level of the currently tested component is indicated using a color scale. Test results can also be displayed in tabular form.</p>

<h2>Functional Features</h2>

<ul>
    <li>Clear and straightforward entry of tested joint parameters.</li>
    <li>Built-in database of the acoustic properties of various materials.</li>
    <li>Automatic gate setting for bottom echo signals.</li>
    <li>Automatic adjustment of bottom echo-signal amplitude.</li>
    <li>Calculation of mechanical stress and force in each component of the joint, expressed in kgf/mm², MPa, or tonnes-force (tf).</li>
    <li>Presentation of results in tabular form or as a force or stress diagram, with tightening levels indicated by color.</li>
    <li>Repeat testing of previously inspected joints, with simultaneous display of multiple test results for the same joint.</li>
    <li>Display of test results on both the instrument and a PC.</li>
</ul>

<h2>Industrial Testing and Specialized Application</h2>

<p>The acoustic tensometry technique was tested at Vyksa Steel Works (OJSC VSW), part of the United Metallurgical Company, and patented.</p>

<p>At the request of ROSAVIAKOSMOS, additional software and hardware modifications were developed for NPO Energomash named after Academician V. P. Glushko in accordance with OST 92-9521. These modifications extend the basic Tomographic 3.2 functionality and are implemented as a separate specialized application called <strong>AKON-4M</strong>.</p>
HTML,
        ],
        'purpose' => 'avia',
        'image' => 'apps/tomographic-5m/3.2/thumb.webp',
        'images' => [
            'apps/tomographic-5m/3.2/1.webp',
            'apps/tomographic-5m/3.2/2.webp',
            'apps/tomographic-5m/3.2/3.webp',
            'apps/tomographic-5m/3.2/4.webp',
        ],
    ],
    [
        'version' => '4.1',
        'name' => [
            'ru' => 'Томографик 4.1 — Вихретоковый дефектоскоп',
            'en' => 'Tomographic 4.1 — Eddy-Current Flaw Detector',
        ],
        'short_description' => [
            'ru' => 'Вихретоковый контроль для выявления усталостных трещин на поверхностях деталей из немагнитных и ферромагнитных сплавов.',
            'en' => 'Eddy-current testing for detecting fatigue cracks on components made of non-magnetic and ferromagnetic alloys.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h1>Томографик 4.1, вихретоковый дефектоскоп</h1>

<p>Вихретоковый дефектоскоп (ВД) «Томографик 4.1» предназначен для выявления дефектов типа усталостных трещин на поверхности деталей из немагнитных и ферромагнитных сплавов.</p>

<p>«Томографик 4.1» обеспечивает контроль плоских и криволинейных поверхностей с радиусом положительной и отрицательной кривизны до 20 мм.</p>

<p>Вихретоковый преобразователь ВТП-2-02 карандашного типа обеспечивает работу в частотном диапазоне от 1 до 10 МГц.</p>

<p>Комплект накладных насадок позволяет контролировать детали из материалов с удельной электропроводностью (0,4–40) × 10<sup>6</sup> См/м.</p>

<p>Информация о текущей точке контроля представлена положением специального курсора на комплексной плоскости.</p>

<p>Изменение наклона преобразователя в пределах 0–15° от нормали к контролируемой поверхности приводит к горизонтальному смещению курсора на комплексной плоскости относительно начала координат, а наличие дефекта приводит к отклонению курсора от горизонтали. Траектория курсора отображается на экране прибора (рис. 1).</p>

<p>Предусмотрена возможность обработки и визуализации развёртки типа А-скан с последующим сохранением в архив (рис. 2). Документирование результатов контроля осуществляется посредством универсального приложения «АРМ Дефектоскописта».</p>

<h2>Технические характеристики</h2>

<ul>
    <li>Обнаружение трещин протяжённостью не менее 3 мм с раскрытием в пределах от 0,05 до 1 мм.</li>
    <li>Угол отклонения преобразователя от нормали к контролируемой поверхности: от 0 до 30°.</li>
    <li>Зазор между преобразователем и контролируемой поверхностью: не более 0,5 мм при шероховатости поверхности Ra 1,25 мкм.</li>
    <li>Минимальное расстояние до края контролируемого изделия: 5 мм.</li>
</ul>
HTML,
            'en' => <<<'HTML'
<h1>Tomographic 4.1, Eddy-Current Flaw Detector</h1>

<p>The Tomographic 4.1 eddy-current flaw detector (ECFD) is designed to detect defects such as fatigue cracks on the surfaces of components made of non-magnetic and ferromagnetic alloys.</p>

<p>Tomographic 4.1 enables the inspection of flat and curved surfaces with positive and negative radii of curvature of up to 20 mm.</p>

<p>The pencil-type eddy-current probe VTP-2-02 operates within a frequency range of 1 to 10 MHz.</p>

<p>A set of interchangeable probe attachments allows the inspection of components made of materials with electrical conductivity ranging from (0.4–40) × 10<sup>6</sup> S/m.</p>

<p>Information about the current inspection point is represented by the position of a special cursor on the complex plane.</p>

<p>A change in the probe angle within 0–15° from the normal to the inspected surface causes the cursor to shift horizontally relative to the origin of the complex plane, while the presence of a defect causes the cursor to deviate from the horizontal direction. The cursor trajectory is displayed on the instrument screen (Fig. 1).</p>

<p>The application also supports processing and visualization of A-scan signals, with subsequent storage in the archive (Fig. 2). Inspection results are documented using the universal NDT Operator AWS application.</p>

<h2>Technical Specifications</h2>

<ul>
    <li>Detection of cracks at least 3 mm long, with opening widths ranging from 0.05 to 1 mm.</li>
    <li>Probe deviation angle from the normal to the inspected surface: 0–30°.</li>
    <li>Maximum gap between the probe and the inspected surface: 0.5 mm at a surface roughness of Ra 1.25 µm.</li>
    <li>Minimum distance from the edge of the inspected component: 5 mm.</li>
</ul>
HTML,
        ],
        'purpose' => 'eddy-current',
        'image' => 'apps/tomographic-5m/4.1/thumb.webp',
        'images' => [
            'apps/tomographic-5m/4.1/1.webp',
            'apps/tomographic-5m/4.1/2.webp',
            'apps/tomographic-5m/4.1/3.webp',
            'apps/tomographic-5m/4.1/4.webp',
        ],
    ],
    [
        'version' => '4.2',
        'name' => [
            'ru' => 'Томографик 4.2 — Толщиномер покрытий',
            'en' => 'Tomographic 4.2 — Coating Thickness Gauge',
        ],
        'short_description' => [
            'ru' => 'Приложение для измерения толщины непроводящих покрытий на магнитных и немагнитных электропроводящих материалах.',
            'en' => 'An application for measuring nonconductive coating thickness on magnetic and non-magnetic electrically conductive materials.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h1>Томографик 4.2</h1>

<p>Программное приложение «Толщиномер покрытий» для дефектоскопа «Томографик УД4-ТМ» предназначено для измерения толщины непроводящих покрытий (лакокрасочных и т. п.), нанесённых на магнитные или немагнитные электропроводящие материалы.</p>

<p>Работа в режиме измерения толщины покрытий состоит из двух этапов: настройки и измерения толщины покрытия.</p>

<p>Перед началом работы необходимо выполнить настройку режима или загрузить ранее сохранённую настройку («Толщиномер» → «Настройка» → «Загрузить настройку»).</p>

<h2>Назначение кнопок меню</h2>

<ul>
    <li><strong>Развёртка</strong> — регулировка развёртки в миллиметрах (шкала толщин).</li>
    <li><strong>Сохранить результат</strong> — сохранение результата контроля в архив.</li>
    <li><strong>Калибровка</strong> — калибровка преобразователя.</li>
    <li><strong>Настройка</strong> — настройка режима измерения толщины покрытий.</li>
</ul>

<h2>Настройка режима</h2>

<p>Настройка режима измерения толщины покрытий состоит из следующих этапов:</p>

<ol>
    <li><strong>Настройка рабочей частоты и усиления.</strong> В меню «Осциллограф» установить значение рабочей частоты преобразователя и усиления принимаемого сигнала. Усиление необходимо отрегулировать таким образом, чтобы при перемещении преобразователя максимальная амплитуда сигнала не выходила за пределы окна.</li>
    <li><strong>Калибровка преобразователя.</strong> Перейти в меню «Толщиномер» и нажать кнопку «Калибровка». Выполнить необходимые действия в соответствии с подсказками прибора. В результате при установке преобразователя на поверхность объекта контроля курсор будет опускаться вниз, а при удалении преобразователя — подниматься вверх.</li>
    <li><strong>Настройка по образцам известной толщины.</strong> Перейти в меню точек. Разместить между преобразователем и объектом контроля непроводящий образец известной толщины и нажать кнопку «Добавить». В строке меню «Толщина» указать соответствующее значение толщины образца. При необходимости обновить уровень точки нажатием кнопки «Обновить». Повторить процедуру для нескольких непроводящих образцов с различной известной толщиной.</li>
    <li><strong>Сохранение настройки.</strong> Если контроль будет проводиться неоднократно, настройку можно сохранить нажатием кнопки «Сохранить настройку».</li>
</ol>

<h2>Алгоритм измерения толщины покрытия</h2>

<ol>
    <li>Приложить датчик к поверхности контролируемого объекта.</li>
    <li>Наблюдать значение измеренной толщины в правом нижнем углу экрана прибора.</li>
    <li>При необходимости сохранить результат в архив, нажав кнопку «Сохранить результат».</li>
</ol>
HTML,
            'en' => <<<'HTML'
<h2>Tomographic 4.2 — Eddy-Current Coating Thickness Gauge</h2>

<p>The “Coating Thickness Gauge” software application for the Tomographic UD4-TM flaw detector is designed to measure the thickness of nonconductive coatings (paints, varnishes, etc.) applied to magnetic or nonmagnetic electrically conductive materials.</p>

<p>Operation in this mode consists of two stages: setup and coating thickness measurement.</p>

<p>Before using the coating thickness measurement mode, configure the settings or load a previously saved configuration (Thickness Gauge → Setup → Load Setup).</p>

<h3>Menu Button Functions</h3>

<ul>
    <li><strong>Sweep</strong> — adjusts the sweep in mm (thickness scale).</li>
    <li><strong>Save Result</strong> — saves the measurement result to the archive.</li>
    <li><strong>Calibration</strong> — calibrates the probe.</li>
    <li><strong>Setup</strong> — configures the coating thickness measurement mode.</li>
</ul>

<h3>Setup Procedure</h3>

<ol>
    <li>In the “Oscilloscope” menu, set the probe operating frequency and the received signal gain. Adjust the gain so that the maximum signal amplitude remains within the display window while moving the probe.</li>
    <li>Open the “Thickness Gauge” menu and press “Calibration”. Follow the instructions displayed by the instrument. After calibration, the cursor moves downward when the probe is placed on the test object and upward when the probe is removed.</li>
    <li>Open the points menu. Place a nonconductive reference specimen of known thickness between the probe and the test object, then press “Add”. Enter the corresponding value in the “Thickness” field. If necessary, update the point level by pressing “Update”. Repeat this procedure for several nonconductive specimens of different known thicknesses.</li>
    <li>If measurements will be performed repeatedly, save the configuration by pressing “Save Setup”.</li>
</ol>

<h3>Coating Thickness Measurement Procedure</h3>

<p>Place the probe against the surface being tested and read the measured thickness value in the lower-right corner of the display.</p>

<p>To save the measurement result in the archive, press “Save Result”.</p>
HTML,
        ],
        'purpose' => 'eddy-current',
        'image' => 'apps/tomographic-5m/4.2/thumb.webp',
        'images' => [
            'apps/tomographic-5m/4.2/1.webp',
            'apps/tomographic-5m/4.2/2.webp',
            'apps/tomographic-5m/4.2/3.webp',
            'apps/tomographic-5m/4.2/4.webp',
        ],
    ],
    [
        'version' => '5.1',
        'name' => [
            'ru' => 'Томографик 5.1 — FlashPlayer',
            'en' => 'Tomographic 5.1 — FlashPlayer',
        ],
        'short_description' => [
            'ru' => 'Сервисное приложение для воспроизведения обучающих роликов и управления списком воспроизведения.',
            'en' => 'A service application for playing training videos and managing the playlist.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h2>Томографик 5.1, FlashPlayer</h2>

<p>Программный модуль «Видео-плеер» (FlashPlayer) представляет собой сервисное приложение, поставляемое с прибором. Основное его предназначение состоит в воспроизведении непосредственно на приборе учебных роликов для различных методик контроля, реализованных в приборе.</p>

<p>Учебный ролик позволяет в более наглядной форме представить особенности и преимущества той или иной методики, реализованной в приборе, и наряду с технической документацией призван дать наиболее полную картину работы с программой, реализующей конкретную методику, а также упростить процесс обучения работе с программой.</p>

<p>Кроме этого, данная программа позволяет воспроизводить любые другие флэш-ролики формата Macromedia Flash (*.swf-файлы) версии 3 и ниже.</p>

<p>Программа представляет собой полнофункциональный проигрыватель, реализующий следующие функции:</p>

<ul>
    <li>Пуск;</li>
    <li>Пауза;</li>
    <li>Стоп;</li>
    <li>Проигрывание следующего;</li>
    <li>Проигрывание предыдущего.</li>
</ul>

<p>Программа позволяет легко управлять имеющимися в приборе роликами, добавляя их в список воспроизведения либо удаляя из него.</p>

<p>Запись новых, а также удаление старых роликов производится при помощи программы АРМ.</p>
HTML,
            'en' => <<<'HTML'
<h2>Tomographic 5.1 — Multimedia Player FlashPlayer</h2>

<p>The Video Player (FlashPlayer) software module is a service application supplied with the instrument. Its primary purpose is to play training videos for various testing techniques implemented in the instrument directly on its screen.</p>

<p>The training videos provide a clearer presentation of the specific features and advantages of each testing technique implemented in the instrument. Together with the technical documentation, they are intended to provide a comprehensive understanding of how to use the software application implementing a particular technique and to simplify the training process.</p>

<p>In addition, the application allows playback of other Flash videos in Macromedia Flash format (*.swf files), version 3 and earlier.</p>

<p>The application is a fully functional player supporting the following functions:</p>

<ul>
    <li>Start;</li>
    <li>Pause;</li>
    <li>Stop;</li>
    <li>Play Next;</li>
    <li>Play Previous.</li>
</ul>

<p>The application allows users to manage the videos stored in the instrument by adding them to or removing them from the playlist.</p>

<p>New videos can be uploaded, and existing videos can be deleted using the AWS application.</p>
HTML,
        ],
        'purpose' => 'service',
        'image' => null,
        'images' => [],
    ],
    [
        'version' => '5.2',
        'name' => [
            'ru' => 'Томографик 5.2 — Арифметический калькулятор',
            'en' => 'Tomographic 5.2 — Arithmetic Calculator',
        ],
        'short_description' => [
            'ru' => 'Встроенный калькулятор для оперативных вычислений при ультразвуковом контроле.',
            'en' => 'A built-in calculator for on-the-fly calculations during ultrasonic testing.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h2>Томографик 5.2 — Арифметический калькулятор</h2>

<p>Для удобства оператора в дефектоскопе УД4-ТМ в базовую комплектацию включена программа «Арифметический калькулятор», предназначенная для выполнения оперативных вычислительных расчётов при ультразвуковом контроле.</p>

<p>Специализированная программа «Арифметический калькулятор» реализует функции стандартного вычислительного инструмента: сложение, вычитание, умножение и деление целых и дробных чисел, как положительных, так и отрицательных.</p>

<p>Программа вызывается из главного меню аналогично другим приложениям. Для работы с калькулятором не требуется специальных навыков, поскольку используются только основные средства управления прибором.</p>
HTML,
            'en' => <<<'HTML'
<h2>Tomographic 5.2 — Arithmetic Calculator</h2>

<p>For operator convenience, the UD4-TM flaw detector includes the “Arithmetic Calculator” application as part of its standard configuration. The application is designed to perform on-the-fly calculations during ultrasonic testing.</p>

<p>The specialized “Arithmetic Calculator” application provides the functions of a standard calculator, including addition, subtraction, multiplication, and division of integers and decimal numbers, both positive and negative.</p>

<p>The application can be launched from the main menu in the same way as other applications. No additional skills are required to operate the calculator, as it uses only the instrument’s basic controls.</p>
HTML,
        ],
        'purpose' => 'service',
        'image' => 'apps/tomographic-5m/5.2/thumb.webp',
        'images' => [
            'apps/tomographic-5m/5.2/1.webp',
            'apps/tomographic-5m/5.2/2.webp',
        ],
    ],
    [
        'version' => '5.4',
        'name' => [
            'ru' => 'Томографик 5.4 — Состояние батареи',
            'en' => 'Tomographic 5.4 — Battery State',
        ],
        'short_description' => [
            'ru' => 'Приложение отображает подробную информацию о состоянии встроенной батареи прибора.',
            'en' => 'An application that displays detailed information about the instrument’s built-in battery.',
        ],
        'full_description' => [
            'ru' => <<<'HTML'
<h2>Томографик 5.4</h2>

<h3>Состояние батареи</h3>

<p>Программа «Состояние батареи» предназначена для получения подробной информации о состоянии встроенной батареи.</p>

<p>Томографик 5.4 позволяет отображать на экране полную информацию о батарее, включая её тип, температуру, текущее напряжение и другие параметры.</p>
HTML,
            'en' => <<<'HTML'
<h2>Tomographic 5.4 — Battery State</h2>

<p>The “Battery State” application is designed to provide more detailed information about the status of the built-in battery.</p>

<p>Tomographic 5.4 allows the instrument to display complete battery information, including battery type, temperature, current voltage, and other parameters.</p>
HTML,
        ],
        'purpose' => 'service',
        'image' => null,
        'images' => [],
    ],
];