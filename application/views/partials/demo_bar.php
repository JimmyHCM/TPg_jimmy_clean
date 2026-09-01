<?php
/**
 * LOCAL DEV ONLY floating stage-switcher for client demos.
 * Renders nothing unless: not production host, signed in, and the session
 * belongs to the demo account (1106900014). Buttons call the Demo controller,
 * which rewrites the account's stage and lands on the matching page.
 */
if (($_SERVER['HTTP_HOST'] ?? '') === 'tpgadmission.engg.hku.hk') return;
if (empty($_SESSION['user_logged']) || ($_SESSION['appNo'] ?? '') != '1106900014') return;
?>
  <style>
    .tp-demo-bar {
      position: fixed;
      right: 16px;
      bottom: 16px;
      z-index: 9999;
      display: flex;
      align-items: center;
      gap: 4px;
      padding: 6px 10px;
      background: #0A2E1E;
      border: 1px solid #C9A24B;
      border-radius: 999px;
      box-shadow: 0 6px 24px rgba(10, 46, 30, .35);
      font-family: 'Inter', sans-serif;
      font-size: .74rem;
    }
    .tp-demo-bar b {
      color: #C9A24B;
      font-weight: 700;
      letter-spacing: .08em;
      margin-right: 4px;
    }
    .tp-demo-bar a {
      color: rgba(255, 255, 255, .85);
      text-decoration: none;
      padding: 4px 9px;
      border-radius: 999px;
      white-space: nowrap;
    }
    .tp-demo-bar a:hover {
      color: #fff;
      background: rgba(201, 162, 75, .25);
      text-decoration: none;
    }
    @media (max-width: 767.98px) { .tp-demo-bar { display: none; } }
  </style>
  <div class="tp-demo-bar" title="Local-dev demo: jump the account to any stage">
    <b>DEMO</b>
    <a href="<?php echo base_url(); ?>demo/pics">0&middot;PICS</a>
    <a href="<?php echo base_url(); ?>demo/fresh">1&middot;First login</a>
    <a href="<?php echo base_url(); ?>demo/upload">2&middot;Documents</a>
    <a href="<?php echo base_url(); ?>demo/offer">3&middot;Offer</a>
    <a href="<?php echo base_url(); ?>demo/payment">4&middot;Payment</a>
    <a href="<?php echo base_url(); ?>demo/done">5&middot;Done</a>
  </div>
