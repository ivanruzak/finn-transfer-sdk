<?php

namespace eiriksm\FinnTransfer;

class XmlBase
{

  /**
   * @var string
   */
  protected $provider;

  /**
   * @var string
   */
  protected $partnerId;

  /**
   * @var string
   */
  protected $documentType;

  /**
   * @var string
   */
  protected $dtd;

  /**
   * @var \DOMDocument
   */
  protected $dom;

  /**
   * @var \DOMElement
   */
  protected $documentBody;

  public function __construct($partner_id, $provider) {
    $this->provider = $provider;
    $this->partnerId = $partner_id;
    $imp = new \DOMImplementation();
    if (!isset($this->documentType) || !isset($this->dtd)) {
      throw new \InvalidArgumentException('Class ' . get_class($this) . ' must provide a documentType and dtd property');
    }
    $dtd = $imp->createDocumentType($this->documentType, '', $this->dtd);
    $this->dom = $imp->createDocument('', '', $dtd);
    $this->dom->encoding = 'UTF-8';
    $this->documentBody = $this->dom->createElement($this->documentType);
    $this->dom->appendChild($this->documentBody);
  }

  public function getXml() {
    // @todo: Maybe throw an exception if not valid?
    $valid = @$this->dom->validate();
    return $this->dom->saveXML();
  }

}
