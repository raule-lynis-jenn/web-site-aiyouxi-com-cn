<?php

/**
 * 站点元信息工具
 * 用于管理和生成站点相关的简短描述文本
 */
class SiteMeta
{
    /**
     * 站点基础配置
     * @var array
     */
    private static array $siteConfig = [
        'name' => '爱游戏',
        'url' => 'https://web-site-aiyouxi.com.cn',
        'version' => '1.0.0',
        'description' => '专业的游戏资讯与评测平台',
        'keywords' => ['爱游戏', '游戏评测', '游戏资讯', '玩家社区'],
        'language' => 'zh-CN',
    ];

    /**
     * 页面元信息模板
     * @var array
     */
    private static array $pageMetaTemplates = [
        'home' => [
            'title' => '%s - 首页',
            'description' => '欢迎来到%s，%s',
            'og_title' => '%s | 游戏玩家首选',
        ],
        'article' => [
            'title' => '%s - %s',
            'description' => '阅读文章：%s，来自%s',
            'og_title' => '%s | %s',
        ],
        'game' => [
            'title' => '%s - %s游戏详情',
            'description' => '了解游戏%s的详细信息，%s为您呈现',
            'og_title' => '%s | %s',
        ],
    ];

    /**
     * 获取站点名称
     * @return string
     */
    public static function getSiteName(): string
    {
        return self::$siteConfig['name'];
    }

    /**
     * 获取站点URL
     * @return string
     */
    public static function getSiteUrl(): string
    {
        return self::$siteConfig['url'];
    }

    /**
     * 生成页面描述文本
     * @param string $pageType 页面类型
     * @param array $params 替换参数
     * @return array 包含title和description的关联数组
     */
    public static function generatePageMeta(string $pageType, array $params = []): array
    {
        $siteName = self::$siteConfig['name'];
        $siteDesc = self::$siteConfig['description'];
        $defaultParams = [
            'site_name' => $siteName,
            'site_desc' => $siteDesc,
        ];
        $mergedParams = array_merge($defaultParams, $params);

        if (!isset(self::$pageMetaTemplates[$pageType])) {
            $pageType = 'home';
        }

        $templates = self::$pageMetaTemplates[$pageType];
        $result = [];

        foreach ($templates as $key => $template) {
            $result[$key] = self::formatTemplate($template, $mergedParams);
        }

        return $result;
    }

    /**
     * 格式化模板字符串
     * @param string $template
     * @param array $params
     * @return string
     */
    private static function formatTemplate(string $template, array $params): string
    {
        $replacements = [];
        foreach ($params as $key => $value) {
            $replacements['%s'] = $value;
        }

        $keys = array_keys($replacements);
        $values = array_values($replacements);

        return str_replace('%s', $values[0] ?? '', $template);
    }

    /**
     * 创建简短描述
     * @param string $content 内容标题或摘要
     * @param string $type 内容类型
     * @return string
     */
    public static function createShortDescription(string $content, string $type = 'article'): string
    {
        $siteName = self::$siteConfig['name'];
        $siteUrl = self::$siteConfig['url'];

        switch ($type) {
            case 'article':
                return sprintf('《%s》- %s推荐文章，更多内容请访问 %s', $content, $siteName, $siteUrl);
            case 'game':
                return sprintf('%s游戏《%s》详情页 - %s', $siteName, $content, $siteUrl);
            case 'home':
            default:
                return sprintf('%s - %s，官方网站 %s', $siteName, $content, $siteUrl);
        }
    }

    /**
     * 获取站点元信息数组
     * @return array
     */
    public static function getSiteMetaArray(): array
    {
        return [
            'title' => self::$siteConfig['name'],
            'description' => self::$siteConfig['description'],
            'url' => self::$siteConfig['url'],
            'keywords' => implode(', ', self::$siteConfig['keywords']),
            'language' => self::$siteConfig['language'],
        ];
    }
}

// 使用示例
$siteUrl = 'https://web-site-aiyouxi.com.cn';
$siteName = '爱游戏';

$homeMeta = SiteMeta::generatePageMeta('home', ['site_name' => $siteName]);
$articleMeta = SiteMeta::generatePageMeta('article', ['site_name' => $siteName, 'article_title' => '最新游戏评测']);
$gameMeta = SiteMeta::generatePageMeta('game', ['site_name' => $siteName, 'game_name' => '原神']);

$shortDesc = SiteMeta::createShortDescription('游戏资讯', 'home');

$metaArray = SiteMeta::getSiteMetaArray();

// 输出示例（实际使用中应转义输出）
// echo '<meta name="description" content="' . htmlspecialchars($homeMeta['description'], ENT_QUOTES, 'UTF-8') . '">';
// echo '<title>' . htmlspecialchars($homeMeta['title'], ENT_QUOTES, 'UTF-8') . '</title>';