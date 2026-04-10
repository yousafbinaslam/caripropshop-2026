import React, { useState, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Link, useLocation } from 'react-router-dom';
import { Menu, X, Phone, Mail, Home as HomeIcon } from 'lucide-react';

const Header: React.FC = () => {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const [isScrolled, setIsScrolled] = useState(false);
  const location = useLocation();
  const isHomePage = location.pathname === '/';

  useEffect(() => {
    const handleScroll = () => {
      setIsScrolled(window.scrollY > 50);
    };
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, [isHomePage]);

  const scrollToSection = (sectionId: string) => {
    if (!isHomePage) {
      window.location.href = `/#${sectionId}`;
      return;
    }
    const element = document.getElementById(sectionId);
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
      setIsMenuOpen(false);
    }
  };

  // Determine logo styling based on background
  const getLogoClasses = () => {
    if (isScrolled || !isHomePage) {
      // White background - use dark logo
      return "h-36 w-auto filter-none";
    } else {
      // Transparent/dark background - use white logo
      return "h-36 w-auto brightness-0 invert";
    }
  };

  return (
    <motion.header
      className="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white shadow-lg"
      initial={{ y: -100 }}
      animate={{ y: 0 }}
      transition={{ duration: 0.6 }}
    >
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center py-3">
          <motion.div
            className="flex items-center space-x-2"
            whileHover={{ scale: 1.05 }}
          >
            <Link to="/" className="flex items-center space-x-3">
              <img 
                src="/Black and White Feminine Real Estate Logo (2) copy.png" 
                alt="Cari Prop Shop Logo" 
                className="h-36 w-auto filter-none transition-all duration-300 drop-shadow-2xl object-contain max-h-36 filter contrast-125 saturate-110"
              />
              <div>
                <h1 className="text-base font-bold text-gray-900 tracking-wide">
                  Cari Prop Shop
                </h1>
                <p className="text-xs text-gray-600 tracking-wide">
                  Premium Interior Design
                </p>
              </div>
            </Link>
          </motion.div>

          {/* Desktop Navigation */}
          <nav className="hidden md:flex items-center space-x-8">
            {!isHomePage && (
              <Link
                to="/"
                className="font-medium transition-colors hover:text-amber-500 flex items-center space-x-1 text-gray-700"
              >
                <HomeIcon className="w-5 h-5" />
                <span>Home</span>
              </Link>
            )}
            {['Home', 'About', 'Services', 'Portfolio', 'Process', 'Contact'].map((item) => (
              <button
                key={item}
                onClick={() => scrollToSection(item.toLowerCase())}
                className="font-medium transition-colors hover:text-amber-500 text-gray-700"
              >
                {item}
              </button>
            ))}
          </nav>

          {/* Spacer for layout balance */}
          <div className="hidden lg:block w-24"></div>

          {/* Mobile Menu Button */}
          <button
            onClick={() => setIsMenuOpen(!isMenuOpen)}
            className="md:hidden p-2 rounded-lg text-gray-700"
          >
            {isMenuOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
          </button>
        </div>
      </div>

      {/* Mobile Menu */}
      <AnimatePresence>
        {isMenuOpen && (
          <motion.div
            initial={{ opacity: 0, height: 0 }}
            animate={{ opacity: 1, height: 'auto' }}
            exit={{ opacity: 0, height: 0 }}
            className="md:hidden bg-white border-t border-gray-200"
          >
            <div className="px-4 py-6 space-y-4">
              {!isHomePage && (
                <Link
                  to="/"
                  className="flex items-center space-x-2 py-2 text-gray-700 hover:text-amber-500 font-medium"
                  onClick={() => setIsMenuOpen(false)}
                >
                  <HomeIcon className="w-4 h-4" />
                  <span>Home</span>
                </Link>
              )}
              {['Home', 'About', 'Services', 'Portfolio', 'Process', 'Contact'].map((item) => (
                <button
                  key={item}
                  onClick={() => scrollToSection(item.toLowerCase())}
                  className="block w-full text-left py-2 text-gray-700 hover:text-amber-500 font-medium"
                >
                  {item}
                </button>
              ))}
              <div className="pt-4 border-t border-gray-200">
                <div className="flex items-center space-x-2 text-gray-600">
                  <Phone className="w-4 h-4" />
                  <span className="text-sm">+6282233039914</span>
                </div>
                <div className="flex items-center space-x-2 text-gray-600 mt-2">
                  <Mail className="w-4 h-4" />
                  <span className="text-sm">info@caripropshop.com</span>
                </div>
              </div>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </motion.header>
  );
};

export default Header;