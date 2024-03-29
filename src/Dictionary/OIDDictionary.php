<?php

namespace Webmasterskaya\CryptoPro\Dictionary;

class OIDDictionary extends AbstractDictionary implements OIDAwareInterface, TitleAwareInterface
{
	use OIDAwareTrait;
	use TitleAwareTrait;

	protected const MAP
		= [
			[
				'OID'   => '1.2.643.2.2.34.6',
				'title' => 'Пользователь Центра Регистрации',
			],
			[
				'OID'   => '1.2.643.2.39.1.1',
				'title' => 'Использование в программных продуктах системы "1С:Предприятие 8"',
			],
			[
				'OID'   => '1.2.643.3.131.1.1',
				'title' => 'ИНН',
			],
			[
				'OID'   => '1.2.643.3.141.1.1',
				'title' => 'РНС ФСС',
			],
			[
				'OID'   => '1.2.643.3.141.1.2',
				'title' => 'КП ФСС',
			],
			[
				'OID'   => '1.2.643.3.2.100.65.13.11',
				'title' => 'Использование в системе АИС "Госзакупки" Сахалинской области.',
			],
			[
				'OID'   => '1.2.643.3.8.100.1',
				'title' => 'Сертификат типа "ekey-ГОСТ"',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.1',
				'title' => 'Общее использование в системах ИОК без права заверения финансовых документов',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.10',
				'title' => 'Для участия в электронных торгах и подписания государственного контракта в  информационных системах Тендерного комитета города Москвы уполномоченными  лицами участников размещения государственного заказа города Москвы',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.11',
				'title' => 'Подписание электронных документов в автоматизированной информационной  системе размещения государственного и муниципального заказа Саратовской области',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.12',
				'title' => 'Использование в системе государственного заказа Иркутской области',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.13',
				'title' => 'Использование в электронной торговой площадке агентства государственного  заказа Красноярского края',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.14',
				'title' => 'Использование в электронной торговой площадке "Тендер"',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.2',
				'title' => 'Передача отчетности по ТКС',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.3',
				'title' => 'Оформление взаимных обязательств, соглашений, договоров, актов и т.п.',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.4',
				'title' => 'Внутрикорпоративный документооборот',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.5',
				'title' => 'Использование в системах электронной торговли',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.6',
				'title' => 'Использование в торгово-закупочной системе "ЭЛЕКТРА"',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.7',
				'title' => 'Использование в системе Портал государственных закупок Ставропольского края.',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.8',
				'title' => 'Использование в Единой системе электронной торговли B2B-Center и B2G.',
			],
			[
				'OID'   => '1.2.643.3.8.100.1.9',
				'title' => 'Для участия в электронных торгах и подписания государственного контракта в  электронной площадке ОАО «ЕЭТП» уполномоченными лицами участников размещения  государственного или муниципального заказа',
			],
			[
				'OID'   => '1.2.643.5.1.24.2.1.3',
				'title' => 'Формирование документов для получения государственных  услуг в сфере ведения государственного кадастра недвижимости со стороны заявителя',
			],
			[
				'OID'   => '1.2.643.5.1.24.2.1.3.1',
				'title' => 'Формирование кадастровым инженером документов  для получения государственных услуг в сфере ведения государственного кадастра недвижимости со стороны  заявителя',
			],
			[
				'OID'   => '1.2.643.5.1.24.2.2.2',
				'title' => 'Формирование документов как результата оказания  услуги со стороны органов регистрации прав',
			],
			[
				'OID'   => '1.2.643.5.1.24.2.2.3',
				'title' => 'Формирование документов для получения государственных  услуг в сфере государственной регистрации прав на недвижимое имущество и сделок с ним со стороны заявителя',
			],
			[
				'OID'   => '1.2.643.6.2.1.7.1',
				'title' => 'Использование единоличным исполнительным органом юридического лица или уполномоченными представителями юридического лица в отношениях, связанных с возникновением, исполнением (осуществлением) и прекращением гражданских и иных прав и обязанностей в сфере негосударственного пенсионного обеспечения, негосударственного пенсионного страхования, в сфере деятельности паевых инвестиционных фондов, акционерных инвестиционных фондов, профессиональных участников рынка ценных бумаг, а также связанной с обслуживанием указанной деятельности услуг кредитных и иных организаций',
			],
			[
				'OID'   => '1.2.643.6.2.1.7.2',
				'title' => 'Использование физическим лицом в отношениях, связанных с возникновением, исполнением (осуществлением) и прекращением гражданских прав и обязанностей в отношении инвестиционных паев паевых инвестиционных фондов, в том числе отношения, связанные с учетом и/или фиксацией прав на инвестиционные паи паевых инвестиционных фондов',
			],
			[
				'OID'   => '1.2.643.6.3',
				'title' => 'Использование в электронных торговых системах и в программном обеспечении, связанным с обменом электронных сообщений',
			],
			[
				'OID'   => '1.2.643.6.3.1.1',
				'title' => 'Использование на электронных площадок отобранных для проведения аукционах в электронной форме',
			],
			[
				'OID'   => '1.2.643.6.3.1.2.1',
				'title' => 'Тип участника - Юридическое лицо',
			],
			[
				'OID'   => '1.2.643.6.3.1.2.2',
				'title' => 'Тип участника - Физическое лицо',
			],
			[
				'OID'   => '1.2.643.6.3.1.2.3',
				'title' => 'Тип участника - Индивидуальный предприниматель',
			],
			[
				'OID'   => '1.2.643.6.3.1.3.1',
				'title' => 'Участник размещения заказа',
			],
			[
				'OID'   => '1.2.643.6.3.1.4.1',
				'title' => 'Администратор организации',
			],
			[
				'OID'   => '1.2.643.6.3.1.4.2',
				'title' => 'Уполномоченный специалист',
			],
			[
				'OID'   => '1.2.643.6.3.1.4.3',
				'title' => 'Специалист с правом подписи контракта',
			],
			[
				'OID'   => '1.2.840.113549.1.9.2',
				'title' => 'Неструктурированное имя',
			],
			[
				'OID'   => '1.3.6.1.4.1.24138.1.1.8.1',
				'title' => 'Обеспечение юридической значимости в Системе "Электронная Торговая Площадка"',
			],
			[
				'OID'   => '1.3.6.1.4.1.29919.21',
				'title' => 'Использование в системе Портал государственных закупок  Ростовской области "Рефери".',
			],
			[
				'OID'   => '1.3.6.1.5.5.7.3.2',
				'title' => 'Проверка подлинности клиента',
			],
			[
				'OID'   => '1.3.6.1.5.5.7.3.4',
				'title' => 'Защищенная электронная почта',
			],
			[
				'OID'   => '1.3.643.3.8.100.15',
				'title' => 'Использование в ЭТП "uTender"',
			],
		];
}