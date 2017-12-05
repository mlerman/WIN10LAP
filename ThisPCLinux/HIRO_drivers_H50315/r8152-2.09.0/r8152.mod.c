#include <linux/module.h>
#include <linux/vermagic.h>
#include <linux/compiler.h>

MODULE_INFO(vermagic, VERMAGIC_STRING);

__visible struct module __this_module
__attribute__((section(".gnu.linkonce.this_module"))) = {
	.name = KBUILD_MODNAME,
	.init = init_module,
#ifdef CONFIG_MODULE_UNLOAD
	.exit = cleanup_module,
#endif
	.arch = MODULE_ARCH_INIT,
};

static const struct modversion_info ____versions[]
__used
__attribute__((section("__versions"))) = {
	{ 0x3d6976bf, __VMLINUX_SYMBOL_STR(module_layout) },
	{ 0x75b5b92e, __VMLINUX_SYMBOL_STR(ethtool_op_get_link) },
	{ 0x9f9e8de3, __VMLINUX_SYMBOL_STR(eth_validate_addr) },
	{ 0x8e5ac881, __VMLINUX_SYMBOL_STR(usb_deregister) },
	{ 0xc4ded348, __VMLINUX_SYMBOL_STR(usb_register_driver) },
	{ 0xff1ff09c, __VMLINUX_SYMBOL_STR(netif_carrier_on) },
	{ 0x2373f491, __VMLINUX_SYMBOL_STR(mutex_trylock) },
	{ 0x9cc4f70a, __VMLINUX_SYMBOL_STR(register_pm_notifier) },
	{ 0xbfc1a3bb, __VMLINUX_SYMBOL_STR(usb_alloc_urb) },
	{ 0x55f5019b, __VMLINUX_SYMBOL_STR(__kmalloc_node) },
	{ 0x542adaeb, __VMLINUX_SYMBOL_STR(netif_device_attach) },
	{ 0xc392623e, __VMLINUX_SYMBOL_STR(netif_carrier_off) },
	{ 0x3c3fce39, __VMLINUX_SYMBOL_STR(__local_bh_enable_ip) },
	{ 0xc654f778, __VMLINUX_SYMBOL_STR(skb_checksum_help) },
	{ 0xb89e712c, __VMLINUX_SYMBOL_STR(__pskb_pull_tail) },
	{ 0xec48a37d, __VMLINUX_SYMBOL_STR(__skb_gso_segment) },
	{ 0x27c33efe, __VMLINUX_SYMBOL_STR(csum_ipv6_magic) },
	{ 0xee69ca77, __VMLINUX_SYMBOL_STR(pskb_expand_head) },
	{ 0x67856eb8, __VMLINUX_SYMBOL_STR(__dev_kfree_skb_any) },
	{ 0x5d8770a0, __VMLINUX_SYMBOL_STR(skb_copy_bits) },
	{ 0xa5109c40, __VMLINUX_SYMBOL_STR(usb_autopm_get_interface_async) },
	{ 0x3c6588a4, __VMLINUX_SYMBOL_STR(netif_schedule_queue) },
	{ 0x7a2af7b4, __VMLINUX_SYMBOL_STR(cpu_number) },
	{ 0xf6e6a50d, __VMLINUX_SYMBOL_STR(napi_complete_done) },
	{ 0xfd0a57a4, __VMLINUX_SYMBOL_STR(__napi_alloc_skb) },
	{ 0xd04b5a37, __VMLINUX_SYMBOL_STR(eth_type_trans) },
	{ 0xdf142e58, __VMLINUX_SYMBOL_STR(skb_put) },
	{ 0x5bff3eb2, __VMLINUX_SYMBOL_STR(napi_gro_receive) },
	{ 0x1916e38c, __VMLINUX_SYMBOL_STR(_raw_spin_unlock_irqrestore) },
	{ 0x680ec266, __VMLINUX_SYMBOL_STR(_raw_spin_lock_irqsave) },
	{ 0xb8b34c4a, __VMLINUX_SYMBOL_STR(usb_autopm_put_interface_async) },
	{ 0x6bf1c17f, __VMLINUX_SYMBOL_STR(pv_lock_ops) },
	{ 0xe259ae9e, __VMLINUX_SYMBOL_STR(_raw_spin_lock) },
	{ 0x9867a518, __VMLINUX_SYMBOL_STR(skb_tstamp_tx) },
	{ 0x6cba670a, __VMLINUX_SYMBOL_STR(__napi_schedule) },
	{ 0x7d11c268, __VMLINUX_SYMBOL_STR(jiffies) },
	{ 0x28e55d9a, __VMLINUX_SYMBOL_STR(skb_queue_tail) },
	{ 0x9f3c1c45, __VMLINUX_SYMBOL_STR(usb_enable_lpm) },
	{ 0xb347bb2c, __VMLINUX_SYMBOL_STR(work_busy) },
	{ 0xc6cbbc89, __VMLINUX_SYMBOL_STR(capable) },
	{ 0xf9a482f9, __VMLINUX_SYMBOL_STR(msleep) },
	{ 0xf6ebc03b, __VMLINUX_SYMBOL_STR(net_ratelimit) },
	{ 0x4f8b5ddb, __VMLINUX_SYMBOL_STR(_copy_to_user) },
	{ 0x4f6b400b, __VMLINUX_SYMBOL_STR(_copy_from_user) },
	{ 0xd81b8dc2, __VMLINUX_SYMBOL_STR(dev_err) },
	{ 0x79aa04a2, __VMLINUX_SYMBOL_STR(get_random_bytes) },
	{ 0x3106016, __VMLINUX_SYMBOL_STR(__dynamic_dev_dbg) },
	{ 0x57ac9a67, __VMLINUX_SYMBOL_STR(_dev_info) },
	{ 0x47e02ebc, __VMLINUX_SYMBOL_STR(usb_driver_set_configuration) },
	{ 0x5ca76dcd, __VMLINUX_SYMBOL_STR(register_netdev) },
	{ 0x13a6e0d5, __VMLINUX_SYMBOL_STR(netif_napi_add) },
	{ 0x131db64a, __VMLINUX_SYMBOL_STR(system_long_wq) },
	{ 0x6b06fdce, __VMLINUX_SYMBOL_STR(delayed_work_timer_fn) },
	{ 0x9580deb, __VMLINUX_SYMBOL_STR(init_timer_key) },
	{ 0x876a9aae, __VMLINUX_SYMBOL_STR(__mutex_init) },
	{ 0xf6a1e404, __VMLINUX_SYMBOL_STR(alloc_etherdev_mqs) },
	{ 0x75fcef9e, __VMLINUX_SYMBOL_STR(usb_reset_device) },
	{ 0x837701c9, __VMLINUX_SYMBOL_STR(kmem_cache_alloc_trace) },
	{ 0x18f427aa, __VMLINUX_SYMBOL_STR(kmalloc_caches) },
	{ 0x12a38747, __VMLINUX_SYMBOL_STR(usleep_range) },
	{ 0x7681946c, __VMLINUX_SYMBOL_STR(unregister_pm_notifier) },
	{ 0x59909e73, __VMLINUX_SYMBOL_STR(usb_free_urb) },
	{ 0x14c7bbba, __VMLINUX_SYMBOL_STR(eth_change_mtu) },
	{ 0xaf51e7cd, __VMLINUX_SYMBOL_STR(usb_queue_reset_device) },
	{ 0x41f0c7b6, __VMLINUX_SYMBOL_STR(netdev_warn) },
	{ 0x28318305, __VMLINUX_SYMBOL_STR(snprintf) },
	{ 0x5792f848, __VMLINUX_SYMBOL_STR(strlcpy) },
	{ 0x2b1de9cb, __VMLINUX_SYMBOL_STR(mii_nway_restart) },
	{ 0x64b8a2d9, __VMLINUX_SYMBOL_STR(usb_autopm_put_interface) },
	{ 0x879b3749, __VMLINUX_SYMBOL_STR(usb_autopm_get_interface) },
	{ 0x16305289, __VMLINUX_SYMBOL_STR(warn_slowpath_null) },
	{ 0x5862ddf2, __VMLINUX_SYMBOL_STR(device_set_wakeup_enable) },
	{ 0xed4a5ca9, __VMLINUX_SYMBOL_STR(free_netdev) },
	{ 0xff5b1e53, __VMLINUX_SYMBOL_STR(unregister_netdev) },
	{ 0xc248f2c6, __VMLINUX_SYMBOL_STR(netif_napi_del) },
	{ 0xbba70a2d, __VMLINUX_SYMBOL_STR(_raw_spin_unlock_bh) },
	{ 0xd9d3bcd3, __VMLINUX_SYMBOL_STR(_raw_spin_lock_bh) },
	{ 0xbae769d4, __VMLINUX_SYMBOL_STR(consume_skb) },
	{ 0x3d435112, __VMLINUX_SYMBOL_STR(netdev_err) },
	{ 0xe5605c83, __VMLINUX_SYMBOL_STR(netdev_info) },
	{ 0x8203e0c5, __VMLINUX_SYMBOL_STR(netif_device_detach) },
	{ 0xc2690330, __VMLINUX_SYMBOL_STR(usb_submit_urb) },
	{ 0x27cfea5a, __VMLINUX_SYMBOL_STR(mutex_unlock) },
	{ 0xb4328ac4, __VMLINUX_SYMBOL_STR(mutex_lock) },
	{ 0xa57863e, __VMLINUX_SYMBOL_STR(cancel_delayed_work_sync) },
	{ 0x277e49f2, __VMLINUX_SYMBOL_STR(usb_kill_urb) },
	{ 0xad57888f, __VMLINUX_SYMBOL_STR(napi_disable) },
	{ 0xeb9c1f99, __VMLINUX_SYMBOL_STR(netdev_notice) },
	{ 0x4c759827, __VMLINUX_SYMBOL_STR(byte_rev_table) },
	{ 0x393d4de9, __VMLINUX_SYMBOL_STR(crc32_le) },
	{ 0x70cd1f, __VMLINUX_SYMBOL_STR(queue_delayed_work_on) },
	{ 0x2d3385d3, __VMLINUX_SYMBOL_STR(system_wq) },
	{ 0x31646f18, __VMLINUX_SYMBOL_STR(netif_tx_wake_queue) },
	{ 0x4629334c, __VMLINUX_SYMBOL_STR(__preempt_count) },
	{ 0x448eac3e, __VMLINUX_SYMBOL_STR(kmemdup) },
	{ 0xdb7305a1, __VMLINUX_SYMBOL_STR(__stack_chk_fail) },
	{ 0xfb578fc5, __VMLINUX_SYMBOL_STR(memset) },
	{ 0x37a0cba, __VMLINUX_SYMBOL_STR(kfree) },
	{ 0x69acdf38, __VMLINUX_SYMBOL_STR(memcpy) },
	{ 0xea4662cc, __VMLINUX_SYMBOL_STR(usb_control_msg) },
	{ 0xd2b09ce5, __VMLINUX_SYMBOL_STR(__kmalloc) },
	{ 0xbdfb6dbb, __VMLINUX_SYMBOL_STR(__fentry__) },
};

static const char __module_depends[]
__used
__attribute__((section(".modinfo"))) =
"depends=mii";

MODULE_ALIAS("usb:v0BDAp8050d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v0BDAp8050d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v0BDAp8152d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v0BDAp8152d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v0BDAp8153d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v0BDAp8153d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v045Ep07ABd*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v045Ep07ABd*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v045Ep07C6d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v045Ep07C6d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v04E8pA101d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v04E8pA101d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v17EFp304Fd*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v17EFp304Fd*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v17EFp3052d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v17EFp3052d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v17EFp3054d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v17EFp3054d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v17EFp3057d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v17EFp3057d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v17EFp3062d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v17EFp3062d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v17EFp3069d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v17EFp3069d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v17EFp7205d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v17EFp7205d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v17EFp720Ad*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v17EFp720Ad*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v17EFp720Bd*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v17EFp720Bd*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v17EFp720Cd*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v17EFp720Cd*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v17EFp7214d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v17EFp7214d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v2357p0601d*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v2357p0601d*dc*dsc*dp*ic02isc06ip00in*");
MODULE_ALIAS("usb:v0955p09FFd*dc*dsc*dp*icFFisc*ip*in*");
MODULE_ALIAS("usb:v0955p09FFd*dc*dsc*dp*ic02isc06ip00in*");

MODULE_INFO(srcversion, "E8A1C1FAC91F6E61EB97621");
