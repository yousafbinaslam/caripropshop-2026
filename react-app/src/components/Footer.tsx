import React from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Phone, Mail, MapPin, Instagram, Facebook, Linkedin, Heart, ArrowRight, Star, Award } from 'lucide-react';

const Footer: React.FC = () => {
  const currentYear = new Date().getFullYear();

  return (
    <footer className="relative bg-gradient-to-br from-slate-900 via-gray-900 to-black text-white overflow-hidden">
      {/* Enhanced background with multiple layers */}
      <div className="absolute inset-0 opacity-5">
        <div className="absolute inset-0" style={{
          backgroundImage: `url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.1'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E")`,
        }} />
      </div>
      
      {/* Gradient overlay for depth */}
      <div className="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
      
      {/* Ambient glow effects */}
      <div className="absolute top-0 left-1/4 w-96 h-96 bg-amber-500/5 rounded-full blur-3xl"></div>
      <div className="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl"></div>

      <div className="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Top section with premium branding */}
        <div className="pt-20 pb-16 border-b border-gray-700/30">
          <motion.div
            initial={{ opacity: 0, y: 30 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            viewport={{ once: true }}
            className="text-center"
          >
            <div className="flex flex-col items-center justify-center mb-8">
              <img 
                src="/Black and White Feminine Real Estate Logo (2) copy.png" 
                alt="Cari Prop Shop Logo" 
                className="h-48 w-auto brightness-0 invert object-contain max-h-48 filter contrast-150 saturate-125 drop-shadow-2xl mb-1"
              />
              <div className="text-center -mt-2">
                <h3 className="text-3xl font-bold bg-gradient-to-r from-white via-gray-100 to-white bg-clip-text text-transparent tracking-wide mb-1">
                  Cari Prop Shop
                </h3>
                <p className="text-gray-300 text-sm font-medium tracking-wider">Premium Interior Design</p>
              </div>
            </div>
            
            <p className="text-lg text-gray-300 max-w-4xl mx-auto leading-relaxed mb-10">
              Transforming spaces with innovative design solutions that blend functionality, 
              aesthetics, and sustainability. Creating extraordinary environments since 2020.
            </p>

            {/* Premium badges */}
            <div className="flex flex-wrap justify-center gap-6 mb-10">
              <div className="flex items-center space-x-2 bg-gradient-to-r from-amber-500/20 to-orange-500/20 px-6 py-3 rounded-full border border-amber-500/30 backdrop-blur-sm hover:from-amber-500/30 hover:to-orange-500/30 transition-all duration-300">
                <Award className="w-5 h-5 text-amber-400" />
                <span className="text-amber-200 text-sm font-medium">Award Winning</span>
              </div>
              <div className="flex items-center space-x-2 bg-gradient-to-r from-green-500/20 to-emerald-500/20 px-6 py-3 rounded-full border border-green-500/30 backdrop-blur-sm hover:from-green-500/30 hover:to-emerald-500/30 transition-all duration-300">
                <Star className="w-5 h-5 text-green-400" />
                <span className="text-green-200 text-sm font-medium">5-Star Rated</span>
              </div>
              <div className="flex items-center space-x-2 bg-gradient-to-r from-blue-500/20 to-indigo-500/20 px-6 py-3 rounded-full border border-blue-500/30 backdrop-blur-sm hover:from-blue-500/30 hover:to-indigo-500/30 transition-all duration-300">
                <Heart className="w-5 h-5 text-blue-400" />
                <span className="text-blue-200 text-sm font-medium">Client Loved</span>
              </div>
            </div>

            {/* Social media with elegant styling */}
            <div className="flex justify-center space-x-6">
              <a href="#" className="group w-14 h-14 bg-gradient-to-br from-gray-700/50 to-gray-800/50 rounded-2xl flex items-center justify-center hover:from-amber-500 hover:to-orange-500 transition-all duration-300 shadow-lg hover:shadow-amber-500/25 hover:scale-110 backdrop-blur-sm border border-gray-600/30">
                <Instagram className="w-6 h-6 group-hover:text-white transition-colors" />
              </a>
              <a href="#" className="group w-14 h-14 bg-gradient-to-br from-gray-700/50 to-gray-800/50 rounded-2xl flex items-center justify-center hover:from-blue-500 hover:to-blue-600 transition-all duration-300 shadow-lg hover:shadow-blue-500/25 hover:scale-110 backdrop-blur-sm border border-gray-600/30">
                <Facebook className="w-6 h-6 group-hover:text-white transition-colors" />
              </a>
              <a href="#" className="group w-14 h-14 bg-gradient-to-br from-gray-700/50 to-gray-800/50 rounded-2xl flex items-center justify-center hover:from-blue-600 hover:to-blue-700 transition-all duration-300 shadow-lg hover:shadow-blue-600/25 hover:scale-110 backdrop-blur-sm border border-gray-600/30">
                <Linkedin className="w-6 h-6 group-hover:text-white transition-colors" />
              </a>
            </div>
          </motion.div>
        </div>

        {/* Main footer content */}
        <div className="py-20">
          <div className="overflow-x-auto">
            <table className="w-full">
              <thead>
                <tr className="border-b border-gray-700/30">
                  <th className="text-left py-6 px-8">
                    <h4 className="text-xl font-bold text-white mb-4 relative">
                      Our Services
                      <div className="absolute -bottom-2 left-0 w-16 h-1 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full"></div>
                    </h4>
                  </th>
                  <th className="text-left py-6 px-8">
                    <h4 className="text-xl font-bold text-white mb-4 relative">
                      Get In Touch
                      <div className="absolute -bottom-2 left-0 w-16 h-1 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full"></div>
                    </h4>
                  </th>
                  <th className="text-left py-6 px-8">
                    <h4 className="text-xl font-bold text-white mb-4 relative">
                      Business Hours
                      <div className="absolute -bottom-2 left-0 w-16 h-1 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full"></div>
                    </h4>
                  </th>
                  <th className="text-left py-6 px-8">
                    <h4 className="text-xl font-bold text-white mb-4 relative">
                      Legal & Policies
                      <div className="absolute -bottom-2 left-0 w-16 h-1 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full"></div>
                    </h4>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr className="align-top">
                  {/* Services Column */}
                  <td className="py-8 px-8 border-r border-gray-700/20">
                    <table className="w-full">
                      <tbody>
                        {[
                          { name: 'Residential Design', link: '/residential-design', premium: true },
                          { name: 'Commercial Design', link: '/commercial-design', premium: true },
                          { name: 'Space Planning', link: '/#services' },
                          { name: 'Lighting Design', link: '/lighting-design', featured: true },
                          { name: 'Project Management', link: '/project-management', featured: true },
                          { name: 'Design Consultation', link: '/design-consultation' }
                        ].map((service, index) => (
                          <tr key={index}>
                            <td className="py-3 group">
                              {service.link.startsWith('/') ? (
                                <Link 
                                  to={service.link} 
                                  className="flex items-center text-gray-300 hover:text-amber-400 transition-all duration-300 group-hover:translate-x-2 py-1"
                                >
                                  <ArrowRight className="w-4 h-4 mr-3 opacity-0 group-hover:opacity-100 transition-all duration-300" />
                                  <span className="relative">
                                    {service.name}
                                    {service.premium && (
                                      <span className="ml-2 px-2 py-0.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs rounded-full">
                                        Premium
                                      </span>
                                    )}
                                    {service.featured && (
                                      <span className="ml-2 px-2 py-0.5 bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs rounded-full">
                                        Featured
                                      </span>
                                    )}
                                  </span>
                                </Link>
                              ) : (
                                <a 
                                  href={service.link} 
                                  className="flex items-center text-gray-300 hover:text-amber-400 transition-all duration-300 group-hover:translate-x-2 py-1"
                                >
                                  <ArrowRight className="w-4 h-4 mr-3 opacity-0 group-hover:opacity-100 transition-all duration-300" />
                                  <span className="relative">
                                    {service.name}
                                    {service.premium && (
                                      <span className="ml-2 px-2 py-0.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs rounded-full">
                                        Premium
                                      </span>
                                    )}
                                  </span>
                                </a>
                              )}
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </td>

                  {/* Contact Information */}
                  <td className="py-8 px-8 border-r border-gray-700/20">
                    <table className="w-full space-y-6">
                      <tbody>
                        <tr>
                          <td className="pb-4">
                            {/* Sales Contact */}
                            <div className="bg-gradient-to-br from-amber-500/15 to-orange-500/15 rounded-2xl p-5 border border-amber-500/25 backdrop-blur-sm hover:from-amber-500/20 hover:to-orange-500/20 transition-all duration-300">
                              <h5 className="font-semibold text-amber-300 mb-3 flex items-center text-sm">
                                <div className="w-2 h-2 bg-amber-400 rounded-full mr-3"></div>
                                Sales & Consultation
                              </h5>
                              <table className="w-full">
                                <tbody>
                                  <tr>
                                    <td className="flex items-center text-gray-300 py-1.5">
                                      <Phone className="w-4 h-4 mr-3 text-amber-400" />
                                      <span className="text-sm">+6282233039914</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td className="flex items-center text-gray-300 py-1.5">
                                      <Mail className="w-4 h-4 mr-3 text-amber-400" />
                                      <span className="text-sm">sales@caripropshop.com</span>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </td>
                        </tr>
                        <tr>
                          <td className="pt-4">
                            {/* Consultation Contact */}
                            <div className="bg-gradient-to-br from-purple-500/15 to-pink-500/15 rounded-2xl p-5 border border-purple-500/25 backdrop-blur-sm hover:from-purple-500/20 hover:to-pink-500/20 transition-all duration-300">
                              <h5 className="font-semibold text-purple-300 mb-3 flex items-center text-sm">
                                <div className="w-2 h-2 bg-purple-400 rounded-full mr-3"></div>
                                Online Consultation
                              </h5>
                              <table className="w-full">
                                <tbody>
                                  <tr>
                                    <td className="flex items-center text-gray-300 py-1.5">
                                      <Phone className="w-4 h-4 mr-3 text-purple-400" />
                                      <span className="text-sm">+6282233541409</span>
                                    </td>
                                  </tr>
                                  <tr>
                                    <td className="flex items-center text-gray-300 py-1.5">
                                      <Mail className="w-4 h-4 mr-3 text-purple-400" />
                                      <span className="text-sm">consult@caripropshop.com</span>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>

                  {/* Business Information */}
                  <td className="py-8 px-8 border-r border-gray-700/20">
                    <div className="bg-gradient-to-br from-blue-500/15 to-indigo-500/15 rounded-2xl p-5 border border-blue-500/25 backdrop-blur-sm hover:from-blue-500/20 hover:to-indigo-500/20 transition-all duration-300">
                      <table className="w-full">
                        <tbody>
                          <tr>
                            <td className="text-gray-300 text-sm py-1.5">Monday - Friday</td>
                            <td className="text-blue-300 font-medium text-sm py-1.5 text-right">9:00 AM - 6:00 PM</td>
                          </tr>
                          <tr>
                            <td className="text-gray-300 text-sm py-1.5">Saturday</td>
                            <td className="text-blue-300 font-medium text-sm py-1.5 text-right">10:00 AM - 4:00 PM</td>
                          </tr>
                          <tr>
                            <td className="text-gray-300 text-sm py-1.5">Sunday</td>
                            <td className="text-amber-300 font-medium text-sm py-1.5 text-right">By Appointment</td>
                          </tr>
                        </tbody>
                      </table>
                      
                      <div className="mt-5 pt-4 border-t border-blue-500/25">
                        <table className="w-full">
                          <tbody>
                            <tr>
                              <td className="flex items-center text-gray-300">
                                <MapPin className="w-4 h-4 mr-3 text-blue-400" />
                                <span className="text-sm">Surabaya East, Indonesia</span>
                              </td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </td>

                  {/* Legal & Policies */}
                  <td className="py-8 px-8">
                    <table className="w-full">
                      <tbody>
                        {[
                          { name: 'Privacy Policy', path: '/privacy-policy', category: 'Essential' },
                          { name: 'Terms & Conditions', path: '/terms-conditions', category: 'Essential' },
                          { name: 'Service Agreement', path: '/service-agreement', category: 'Contract' },
                          { name: 'Refund Policy', path: '/refund-policy', category: 'Financial' },
                          { name: 'Professional Standards', path: '/professional-standards', category: 'Quality' },
                          { name: 'Client Rights & Protections', path: '/client-rights-protections', category: 'Protection' }
                        ].map((policy, index) => (
                          <tr key={index}>
                            <td className="py-2">
                              <Link 
                                to={policy.path} 
                                className="group flex items-center justify-between text-gray-400 hover:text-amber-400 transition-all duration-300 py-3 px-4 rounded-xl hover:bg-gray-800/30 w-full backdrop-blur-sm"
                              >
                                <span className="text-sm">{policy.name}</span>
                                <span className="text-xs px-3 py-1 bg-gray-700/50 rounded-full group-hover:bg-amber-500/20 transition-colors">
                                  {policy.category}
                                </span>
                              </Link>
                            </td>
                          </tr>
                        ))}
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        {/* Mobile responsive version */}
        <div className="py-20 lg:hidden">
          <div className="grid grid-cols-1 gap-12">
            {/* Services Column */}
            <div className="space-y-6">
              <h4 className="text-xl font-bold text-white mb-6 relative">
                Our Services
                <div className="absolute -bottom-2 left-0 w-16 h-1 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full"></div>
              </h4>
              <div className="space-y-4">
                {[
                  { name: 'Residential Design', link: '/residential-design', premium: true },
                  { name: 'Commercial Design', link: '/commercial-design', premium: true },
                  { name: 'Space Planning', link: '/#services' },
                  { name: 'Lighting Design', link: '/lighting-design', featured: true },
                  { name: 'Project Management', link: '/project-management', featured: true },
                  { name: 'Design Consultation', link: '/design-consultation' }
                ].map((service, index) => (
                  <div key={index} className="group">
                    {service.link.startsWith('/') ? (
                      <Link 
                        to={service.link} 
                        className="flex items-center text-gray-300 hover:text-amber-400 transition-all duration-300 group-hover:translate-x-2 py-2"
                      >
                        <ArrowRight className="w-4 h-4 mr-3 opacity-0 group-hover:opacity-100 transition-all duration-300" />
                        <span className="relative">
                          {service.name}
                          {service.premium && (
                            <span className="ml-2 px-2 py-0.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs rounded-full">
                              Premium
                            </span>
                          )}
                          {service.featured && (
                            <span className="ml-2 px-2 py-0.5 bg-gradient-to-r from-blue-500 to-purple-500 text-white text-xs rounded-full">
                              Featured
                            </span>
                          )}
                        </span>
                      </Link>
                    ) : (
                      <a 
                        href={service.link} 
                        className="flex items-center text-gray-300 hover:text-amber-400 transition-all duration-300 group-hover:translate-x-2 py-2"
                      >
                        <ArrowRight className="w-4 h-4 mr-3 opacity-0 group-hover:opacity-100 transition-all duration-300" />
                        <span className="relative">
                          {service.name}
                          {service.premium && (
                            <span className="ml-2 px-2 py-0.5 bg-gradient-to-r from-amber-500 to-orange-500 text-white text-xs rounded-full">
                              Premium
                            </span>
                          )}
                        </span>
                      </a>
                    )}
                  </div>
                ))}
              </div>
            </div>

            {/* Contact Information */}
            <div className="space-y-6">
              <h4 className="text-xl font-bold text-white mb-6 relative">
                Get In Touch
                <div className="absolute -bottom-2 left-0 w-16 h-1 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full"></div>
              </h4>
              
              <div className="space-y-6">
                {/* Sales Contact */}
                <div className="bg-gradient-to-br from-amber-500/15 to-orange-500/15 rounded-2xl p-6 border border-amber-500/25 backdrop-blur-sm hover:from-amber-500/20 hover:to-orange-500/20 transition-all duration-300">
                  <h5 className="font-semibold text-amber-300 mb-3 flex items-center">
                    <div className="w-2 h-2 bg-amber-400 rounded-full mr-3"></div>
                    Sales & Consultation
                  </h5>
                  <div className="space-y-3">
                    <div className="flex items-center text-gray-300">
                      <Phone className="w-4 h-4 mr-3 text-amber-400" />
                      <span className="text-sm">+6282233039914</span>
                    </div>
                    <div className="flex items-center text-gray-300">
                      <Mail className="w-4 h-4 mr-3 text-amber-400" />
                      <span className="text-sm">sales@caripropshop.com</span>
                    </div>
                  </div>
                </div>

                {/* Consultation Contact */}
                <div className="bg-gradient-to-br from-purple-500/15 to-pink-500/15 rounded-2xl p-6 border border-purple-500/25 backdrop-blur-sm hover:from-purple-500/20 hover:to-pink-500/20 transition-all duration-300">
                  <h5 className="font-semibold text-purple-300 mb-3 flex items-center">
                    <div className="w-2 h-2 bg-purple-400 rounded-full mr-3"></div>
                    Online Consultation
                  </h5>
                  <div className="space-y-3">
                    <div className="flex items-center text-gray-300">
                      <Phone className="w-4 h-4 mr-3 text-purple-400" />
                      <span className="text-sm">+6282233541409</span>
                    </div>
                    <div className="flex items-center text-gray-300">
                      <Mail className="w-4 h-4 mr-3 text-purple-400" />
                      <span className="text-sm">consult@caripropshop.com</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {/* Business Information */}
            <div className="space-y-6">
              <h4 className="text-xl font-bold text-white mb-6 relative">
                Business Hours
                <div className="absolute -bottom-2 left-0 w-16 h-1 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full"></div>
              </h4>
              
              <div className="bg-gradient-to-br from-blue-500/15 to-indigo-500/15 rounded-2xl p-6 border border-blue-500/25 backdrop-blur-sm hover:from-blue-500/20 hover:to-indigo-500/20 transition-all duration-300">
                <div className="space-y-4">
                  <div className="flex justify-between items-center">
                    <span className="text-gray-300 text-sm">Monday - Friday</span>
                    <span className="text-blue-300 font-medium text-sm">9:00 AM - 6:00 PM</span>
                  </div>
                  <div className="flex justify-between items-center">
                    <span className="text-gray-300 text-sm">Saturday</span>
                    <span className="text-blue-300 font-medium text-sm">10:00 AM - 4:00 PM</span>
                  </div>
                  <div className="flex justify-between items-center">
                    <span className="text-gray-300 text-sm">Sunday</span>
                    <span className="text-amber-300 font-medium text-sm">By Appointment</span>
                  </div>
                </div>
                
                <div className="mt-6 pt-4 border-t border-blue-500/25">
                  <div className="flex items-center text-gray-300">
                    <MapPin className="w-4 h-4 mr-3 text-blue-400" />
                    <span className="text-sm">Surabaya East, Indonesia</span>
                  </div>
                </div>
              </div>
            </div>

            {/* Legal & Policies */}
            <div className="space-y-6">
              <h4 className="text-xl font-bold text-white mb-6 relative">
                Legal & Policies
                <div className="absolute -bottom-2 left-0 w-16 h-1 bg-gradient-to-r from-amber-400 to-orange-500 rounded-full"></div>
              </h4>
              
              <div className="grid grid-cols-1 gap-3">
                {[
                  { name: 'Privacy Policy', path: '/privacy-policy', category: 'Essential' },
                  { name: 'Terms & Conditions', path: '/terms-conditions', category: 'Essential' },
                  { name: 'Service Agreement', path: '/service-agreement', category: 'Contract' },
                  { name: 'Refund Policy', path: '/refund-policy', category: 'Financial' },
                  { name: 'Professional Standards', path: '/professional-standards', category: 'Quality' },
                  { name: 'Client Rights & Protections', path: '/client-rights-protections', category: 'Protection' }
                ].map((policy, index) => (
                  <Link 
                    key={index}
                    to={policy.path} 
                    className="group flex items-center justify-between text-gray-400 hover:text-amber-400 transition-all duration-300 py-3 px-4 rounded-xl hover:bg-gray-800/30 backdrop-blur-sm"
                  >
                    <span className="text-sm">{policy.name}</span>
                    <span className="text-xs px-3 py-1 bg-gray-700/50 rounded-full group-hover:bg-amber-500/20 transition-colors">
                      {policy.category}
                    </span>
                  </Link>
                ))}
              </div>
            </div>
          </div>
        </div>

        {/* Bottom section with enhanced styling */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6, delay: 0.5 }}
          viewport={{ once: true }}
          className="border-t border-gray-700/30 pt-10 pb-10"
        >
          <div className="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">
            <div className="text-center lg:text-left">
              <p className="text-gray-300 text-sm">
                © {currentYear} Cari Prop Shop by{' '}
                <span className="text-amber-400 font-medium">Invologi (MiYu Innovasi Teknologi)</span>
              </p>
              <p className="text-gray-400 text-xs mt-1">
                All rights reserved. Licensed Interior Design Firm.
              </p>
            </div>
            
            <div className="flex items-center space-x-6">
              <div className="flex items-center space-x-2 text-gray-300">
                <div className="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span className="text-xs">Available for consultation</span>
              </div>
              <div className="text-gray-400 text-xs">
                EST. 2020
              </div>
            </div>
          </div>
        </motion.div>
      </div>
    </footer>
  );
};

export default Footer;