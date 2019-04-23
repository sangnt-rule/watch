<?php
/**
 * Created by PhpStorm.
 * User: DELL
 * Date: 2/9/15
 * Time: 1:38 PM
 */
class Application_Cache_Default extends Application_Cache
{
    public function configActive()
    {
        return Application_Constant_Cache::CONFIG_ACTIVE;
    }

    public function locale()
    {
        return Application_Constant_Cache::LOCALE;
    }

    public function tourCategory()
    {
        return Application_Constant_Cache::TOUR_CATEGORY;
    }

    public function newsCategory()
    {
        return Application_Constant_Cache::NEWS_CATEGORY;
    }

    public function resetNewsCategory()
    {
        $this->remove($this->newsCategory());
    }

    public function newsCategoryOriginal($id)
    {
        return __FUNCTION__ . $id;
    }

    public function scheduleCategoryOriginal($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetScheduleCategoryOriginal($id)
    {
        $this->remove($this->scheduleCategoryOriginal($id));
    }

    public function faqCategory()
    {
        return Application_Constant_Cache::FAQ_CATEGORY;
    }

    public function aboutUsCategory()
    {
        return Application_Constant_Cache::ABOUT_US_CATEGORY;
    }


    public function resetAboutUsCategory()
    {
        $this->remove($this->aboutUsCategory());
    }

    public function aboutUsCategoryInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetAboutUsCategoryInfo($id)
    {
        $this->remove($this->aboutUsCategoryInfo($id));
    }

    public function aboutUsSubCategory()
    {
        return __FUNCTION__;
    }

    public function resetAboutUsSubCategory()
    {
        $this->remove($this->aboutUsSubCategory());
    }

    public function aboutUsSubCategoryInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetAboutUsSubCategoryInfo($id)
    {
        $this->remove($this->aboutUsSubCategoryInfo($id));
    }

    public function featureCategory()
    {
        return Application_Constant_Cache::FEATURE_CATEGORY;
    }

    public function featureCategoryOriginal($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetFeatureCategory()
    {
        $this->remove($this->featureCategory());
    }

    public function featureCategoryInfo($id)
    {
        return __FUNCTION__ .  $id;
    }

    public function resetFeatureCategoryInfo($id)
    {
        $this->remove($this->featureCategoryInfo($id));
    }

    public function featureSubCategory()
    {
        return Application_Constant_Cache::FEATURE_SUB_CATEGORY;
    }

    public function resetFeatureSubCategory()
    {
        $this->remove($this->featureSubCategory());
    }

    public function featureSubCategoryInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetFeatureSubCategoryInfo($id)
    {
        $this->remove($this->featureSubCategoryInfo($id));
    }

    public function slider()
    {
        return __FUNCTION__;
    }

    public function resetSlider()
    {
        $this->remove($this->slider());
    }

    public function contentInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetContentInfo($id)
    {
        $this->remove($this->contentInfo($id));
    }

    public function recruitment()
    {
        return __FUNCTION__;
    }

    public function resetRecruitment()
    {
        $this->remove($this->recruitment());
    }

    public function recruitmentInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetRecruitmentInfo($id)
    {
        $this->remove($this->recruitmentInfo($id));
    }

    public function newsInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetNewsInfo($id)
    {
        $this->remove($this->newsInfo($id));
    }

    public function newsSponsor($locale)
    {
        return __FUNCTION__ . $locale;
    }

    public function resetNewsSponsor()
    {
        $localeData = Admin_Model_Locale::getInstance()->getAll();
        if ($localeData) {
            $localeData = array_keys($localeData);
            foreach ($localeData as $locale) {
                $this->remove($this->newsSponsor($locale));
            }
        }
    }
    public function tourInfo($id)
    {
        return __FUNCTION__ . $id;
    }
    public function resetTourInfo($id)
    {
        $this->remove($this->tourInfo($id));
    }
    public function resetTourSponsor()
    {
        $localeData = Admin_Model_Locale::getInstance()->getAll();
        if ($localeData) {
            $localeData = array_keys($localeData);
            foreach ($localeData as $locale) {
                $this->remove($this->tourSponsor($locale));
            }
        }
    }
    public function tourSponsor($locale)
    {
        return __FUNCTION__ . $locale;
    }

    public function resetTourCategory()
    {
        $this->remove($this->tourCategory());
    }

    public function bookingStatus()
    {
        return __FUNCTION__;
    }

    public function banner()
    {
        return __FUNCTION__;
    }

    public function resetBanner()
    {
        $this->remove($this->banner());
    }

    public function scheduleCategory()
    {
        return __FUNCTION__;
    }

    public function resetScheduleCategory()
    {
        $this->remove($this->scheduleCategory());
    }

    public function scheduleInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetScheduleInfo($id)
    {
        $this->remove($this->scheduleInfo($id));
    }

    public function scheduleSponsor()
    {
        return __FUNCTION__;
    }

    public function resetScheduleSponsor()
    {
        $this->remove($this->scheduleSponsor());
    }

    #Report
    public function reportCategory()
    {
        return __FUNCTION__;
    }

    public function resetReportCategory()
    {
        $this->remove($this->reportCategory());
    }

    public function reportInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetReportInfo($id)
    {
        $this->remove($this->reportInfo($id));
    }

    public function reportSponsor($locale)
    {
        return __FUNCTION__ . $locale;
    }

    public function resetReportSponsor()
    {
        $localeData = Admin_Model_Locale::getInstance()->getAll();
        if ($localeData) {
            $localeData = array_keys($localeData);
            foreach ($localeData as $locale) {
                $this->remove($this->reportSponsor($locale));
            }
        }
    }

    #Service
    public function serviceCategory()
    {
        return __FUNCTION__;
    }

    public function resetServiceCategory()
    {
        $this->remove($this->serviceCategory());
    }

    public function serviceInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetServiceInfo($id)
    {
        $this->remove($this->serviceInfo($id));
    }

    public function serviceSponsor()
    {
        return __FUNCTION__;
    }

    public function resetServiceSponsor()
    {
        $this->remove($this->serviceSponsor());
    }

    #Club
    public function clubCategory()
    {
        return __FUNCTION__;
    }

    public function resetClubCategory()
    {
        $this->remove($this->clubCategory());
    }

    public function clubInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetClubInfo($id)
    {
        $this->remove($this->clubInfo($id));
    }

    public function clubSponsor()
    {
        return __FUNCTION__;
    }

    public function resetClubSponsor()
    {
        $this->remove($this->clubSponsor());
    }

    #Member
    public function memberCategory()
    {
        return __FUNCTION__;
    }

    public function resetMemberCategory()
    {
        $this->remove($this->memberCategory());
    }

    public function memberInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetMemberInfo($id)
    {
        $this->remove($this->memberInfo($id));
    }

    public function memberSponsor()
    {
        return __FUNCTION__;
    }

    public function resetMemberSponsor()
    {
        $this->remove($this->memberSponsor());
    }

    public function memberCategoryInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetMemberCategoryInfo($id)
    {
        $this->remove($this->memberCategoryInfo($id));
    }

    public function serviceCategoryInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetServiceCategoryInfo($id)
    {
        $this->remove($this->serviceCategoryInfo($id));
    }

    public function scheduleCategoryInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetScheduleCategoryInfo($id)
    {
        $this->remove($this->scheduleCategoryInfo($id));
    }

    public function clubCategoryInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetClubCategoryInfo($id)
    {
        $this->remove($this->clubCategoryInfo($id));
    }

    public function sliderSouvenir()
    {
        return __FUNCTION__ ;
    }

    public function resetSliderSouvenir()
    {
        $this->remove($this->sliderSouvenir());
    }

    public function youtube()
    {
        return __FUNCTION__ ;
    }

    public function resetYoutube()
    {
        $this->remove($this->youtube());
    }

    public function newestCategory($category)
    {
        return __FUNCTION__ . $category;
    }

    public function resetNewestCategory()
    {
        $newsCategoryData = Model_NewsCategory::getInstance()->getAll();
        if ($newsCategoryData) {
            foreach ($newsCategoryData as $data) {
                $this->remove($this->newestCategory($data[DbTable_News_Category::COL_NEWS_CATEGORY_ID]));
            }
        }

    }

    public function reportNewest($localeId)
    {
        return __FUNCTION__ . $localeId;
    }

    public function resetReportNewest()
    {
        $localeData = Admin_Model_Locale::getInstance()->getAll();
        if ($localeData) {
            $localeData = array_keys($localeData);
            foreach ($localeData as $locale) {
                $this->remove($this->reportNewest($locale));
            }
        }
    }
    public function resettourestCategory()
    {
        $tourCategoryData = Model_TourCategory::getInstance()->getAll();
        if ($tourCategoryData) {
            foreach ($tourCategoryData as $data) {
                $this->remove($this->tourestCategory($data[DbTable_Tour_Category::COL_TOUR_CATEGORY_ID]));
            }
        }

    }
    public function tourestCategory($category)
    {
        return __FUNCTION__ . $category;
    }

    public function horseType()
    {
        return __FUNCTION__ ;
    }

    public function horse()
    {
        return __FUNCTION__ ;
    }

    public function resetHorse()
    {
        $this->remove($this->horse());
    }

    public function horseInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetHorseInfo($id)
    {
        $this->remove($this->horseInfo($id));
    }

    public function projectCategory()
    {
        return __FUNCTION__;
    }

    public function resetProjectCategory()
    {
        $this->remove($this->projectCategory());
    }

    public function projectCategoryInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetProjectCategoryInfo($id)
    {
        $this->remove($this->projectCategoryInfo($id));
    }

    public function projectCategoryOriginal($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetProjectCategoryOriginal($id)
    {
        $this->remove($this->projectCategoryOriginal($id));
    }

    public function partnerCategory()
    {
        return __FUNCTION__;
    }

    public function resetPartnerCategory()
    {
        $this->remove($this->partnerCategory());
    }

    public function partnerCategoryInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetPartnerCategoryInfo($id)
    {
        $this->remove($this->partnerCategoryInfo($id));
    }

    public function introCategory()
    {
        return __FUNCTION__;
    }

    public function resetIntroCategory()
    {
        $this->remove($this->introCategory());
    }

    public function introCategoryInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetIntroCategoryInfo($id)
    {
        $this->remove($this->introCategoryInfo($id));
    }

    public function valueCategory()
    {
        return __FUNCTION__;
    }

    public function resetValueCategory()
    {
        $this->remove($this->valueCategory());
    }

    public function valueCategoryInfo($id)
    {
        return __FUNCTION__ . $id;
    }

    public function resetValueCategoryInfo($id)
    {
        $this->remove($this->valueCategoryInfo($id));
    }

    public function newest($locateId)
    {
        return __FUNCTION__ . $locateId;
    }

    public function resetNewest()
    {
        $localeData = Admin_Model_Locale::getInstance()->getAll();
        if ($localeData) {
            $localeData = array_keys($localeData);
            foreach ($localeData as $locale) {
                $this->remove($this->newest($locale));
            }
        }
    }
    public function resetTourest()
    {
        $localeData = Admin_Model_Locale::getInstance()->getAll();
        if ($localeData) {
            $localeData = array_keys($localeData);
            foreach ($localeData as $locale) {
                $this->remove($this->tourest($locale));
            }
        }
    }
    public function tourest($locateId)
    {
        return __FUNCTION__ . $locateId;
    }
}