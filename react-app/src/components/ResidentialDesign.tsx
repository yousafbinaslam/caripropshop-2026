import React, { useState } from 'react';
import { motion } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Home, Heart, Users, Palette, Lightbulb, Shield, CheckCircle, Send, Phone, Mail, ArrowLeft, Star, Award, Camera, Ruler } from 'lucide-react';
import { sendAutomatedResponse } from '../utils/emailService';
import Header from './Header';

const ResidentialDesign: React.FC = () => {
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    phone: '',
    propertyType: '',
    propertySize: '',
    rooms: '',
    style: '',
    timeline: '',
    location: '',
    currentStage: '',
    priorities: '',
    message: ''
  });
  const [isSubmitted, setIsSubmitted] = useState(false);

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    
    // Send automated response and admin notification
    sendAutomatedResponse({
      name: formData.name,
      email: formData.email,
      phone: formData.phone,
      formType: 'Residential Design Consultation',
      propertyType: formData.propertyType,
      propertySize: formData.propertySize,
      rooms: formData.rooms,
      style: formData.style,
      timeline: formData.timeline,
      location: formData.location,
      currentStage: formData.currentStage,
      priorities: formData.priorities,
      message: formData.message
    });
    
    setIsSubmitted(true);
    setTimeout(() => setIsSubmitted(false), 3000);
    setFormData({
      name: '',
      email: '',
      phone: '',
      propertyType: '',
      propertySize: '',
      rooms: '',
      style: '',
      timeline: '',
      location: '',
      currentStage: '',
      priorities: '',
      message: ''
    });
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value
    });
  };

  return (
    <div className="min-h-screen bg-gray-50">
      <Header />
      <div className="pt-20">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="py-20">
          {/* Back Navigation */}
          <motion.div
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            className="mb-8"
          >
            <Link to="/" className="flex items-center text-amber-600 hover:text-amber-700 transition-colors">
              <ArrowLeft className="w-5 h-5 mr-2" />
              Back to Home
            </Link>
          </motion.div>

        {/* Hero Section */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          className="text-center mb-16"
        >
          <div className="flex justify-center mb-6">
            <div className="w-20 h-20 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center">
              <Home className="w-10 h-10 text-white" />
            </div>
          </div>
          <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
            Residential Interior Design
          </h1>
          <p className="text-xl text-gray-600 max-w-3xl mx-auto">
            Transform your house into a dream home with our premium residential interior design services. 
            We create personalized spaces that reflect your lifestyle, personality, and aspirations.
          </p>
        </motion.div>

        {/* Services Overview */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.2 }}
          className="grid md:grid-cols-3 gap-8 mb-16"
        >
          {[
            {
              icon: Heart,
              title: 'Personalized Design',
              description: 'Custom designs tailored to your lifestyle and preferences',
              features: ['Lifestyle assessment', 'Personal style analysis', 'Custom color schemes', 'Unique layouts']
            },
            {
              icon: Users,
              title: 'Family-Focused Solutions',
              description: 'Designs that work for every family member and life stage',
              features: ['Child-safe materials', 'Multi-functional spaces', 'Aging-in-place design', 'Pet-friendly options']
            },
            {
              icon: Shield,
              title: 'Quality & Comfort',
              description: 'Premium materials and finishes for lasting beauty and comfort',
              features: ['High-quality materials', 'Comfort optimization', 'Durability focus', 'Warranty protection']
            }
          ].map((service, index) => (
            <motion.div
              key={index}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: 0.3 + index * 0.1 }}
              className="bg-white rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow"
            >
              <service.icon className="w-12 h-12 text-green-500 mb-6" />
              <h3 className="text-xl font-bold text-gray-900 mb-4">{service.title}</h3>
              <p className="text-gray-600 mb-6">{service.description}</p>
              <ul className="space-y-2">
                {service.features.map((feature, i) => (
                  <li key={i} className="flex items-center text-gray-700">
                    <CheckCircle className="w-4 h-4 text-green-500 mr-3" />
                    {feature}
                  </li>
                ))}
              </ul>
            </motion.div>
          ))}
        </motion.div>

        {/* Design Styles */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.4 }}
          className="bg-white rounded-2xl p-8 shadow-lg mb-16"
        >
          <h2 className="text-3xl font-bold text-gray-900 text-center mb-12">Popular Design Styles</h2>
          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            {[
              {
                style: 'Modern Minimalist',
                description: 'Clean lines, neutral colors, and functional design',
                image: 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=400'
              },
              {
                style: 'Scandinavian',
                description: 'Light woods, cozy textures, and hygge comfort',
                image: 'https://images.pexels.com/photos/1571468/pexels-photo-1571468.jpeg?auto=compress&cs=tinysrgb&w=400'
              },
              {
                style: 'Contemporary Luxury',
                description: 'Premium materials, bold accents, and sophistication',
                image: 'https://images.pexels.com/photos/1571453/pexels-photo-1571453.jpeg?auto=compress&cs=tinysrgb&w=400'
              },
              {
                style: 'Traditional Elegance',
                description: 'Classic furniture, rich colors, and timeless appeal',
                image: 'https://images.pexels.com/photos/380768/pexels-photo-380768.jpeg?auto=compress&cs=tinysrgb&w=400'
              }
            ].map((style, index) => (
              <div key={index} className="text-center group">
                <div className="relative overflow-hidden rounded-lg mb-4">
                  <img 
                    src={style.image} 
                    alt={style.style}
                    className="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300"
                  />
                  <div className="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition-colors duration-300" />
                </div>
                <h3 className="text-lg font-semibold text-gray-900 mb-2">{style.style}</h3>
                <p className="text-gray-600 text-sm">{style.description}</p>
              </div>
            ))}
          </div>
        </motion.div>

        {/* Process & Consultation Notice */}
        <div className="grid lg:grid-cols-2 gap-12 mb-16">
          <motion.div
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8, delay: 0.5 }}
            className="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl p-8"
          >
            <h2 className="text-2xl font-bold text-gray-900 mb-6">Our Design Process</h2>
            <div className="space-y-6">
              {[
                { step: '1', title: 'Home Assessment', desc: 'Detailed evaluation of your space and lifestyle' },
                { step: '2', title: 'Design Concept', desc: 'Custom design proposal with mood boards and layouts' },
                { step: '3', title: 'Material Selection', desc: 'Curated selection of furniture, finishes, and decor' },
                { step: '4', title: 'Implementation', desc: 'Professional installation and styling' },
                { step: '5', title: 'Final Styling', desc: 'Perfect finishing touches and home reveal' }
              ].map((phase, index) => (
                <div key={index} className="flex items-start">
                  <div className="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center font-bold text-sm mr-4 mt-1">
                    {phase.step}
                  </div>
                  <div>
                    <h3 className="font-semibold text-gray-900 mb-1">{phase.title}</h3>
                    <p className="text-gray-600 text-sm">{phase.desc}</p>
                  </div>
                </div>
              ))}
            </div>
          </motion.div>

          <motion.div
            initial={{ opacity: 0, x: 20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8, delay: 0.6 }}
            className="bg-white rounded-2xl p-8 shadow-lg"
          >
            <h2 className="text-2xl font-bold text-gray-900 mb-6">Design Services</h2>
            
            {/* Consultation Notice */}
            <div className="bg-amber-50 rounded-lg p-6 mb-6 border-l-4 border-amber-500">
              <h3 className="font-semibold text-gray-900 mb-2">📋 Consultation Charges</h3>
              <p className="text-gray-700 text-sm mb-3">
                All consultations are billed on hourly basis to ensure personalized attention and value for your time.
              </p>
              <p className="text-amber-700 font-medium text-sm">Consult Now for detailed pricing and packages</p>
            </div>

            <div className="space-y-6">
              {[
                {
                  package: 'Essential Home Design',
                  includes: ['Design consultation', 'Room layout plan', 'Color scheme', 'Furniture recommendations']
                },
                {
                  package: 'Complete Home Transformation',
                  includes: ['Full design service', '3D visualizations', 'Material sourcing', 'Project management']
                },
                {
                  package: 'Luxury Home Experience',
                  includes: ['White-glove service', 'Custom furniture', 'Premium materials', 'Concierge support']
                }
              ].map((pkg, index) => (
                <div key={index} className="border border-gray-200 rounded-lg p-4">
                  <div className="flex justify-between items-start mb-3">
                    <h3 className="font-semibold text-gray-900">{pkg.package}</h3>
                    <span className="text-green-600 font-bold">Consult Now</span>
                  </div>
                  <ul className="space-y-1">
                    {pkg.includes.map((item, i) => (
                      <li key={i} className="text-gray-600 text-sm flex items-center">
                        <CheckCircle className="w-3 h-3 text-green-500 mr-2" />
                        {item}
                      </li>
                    ))}
                  </ul>
                </div>
              ))}
            </div>
          </motion.div>
        </div>

        {/* Portfolio Showcase */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.7 }}
          className="bg-white rounded-2xl p-8 shadow-lg mb-16"
        >
          <h2 className="text-3xl font-bold text-gray-900 text-center mb-12">Recent Residential Projects</h2>
          <div className="grid md:grid-cols-3 gap-8">
            {[
              {
                title: 'Modern Family Home',
                location: 'Jakarta',
                size: '250 sqm',
                image: 'https://images.pexels.com/photos/1170412/pexels-photo-1170412.jpeg?auto=compress&cs=tinysrgb&w=400'
              },
              {
                title: 'Luxury Penthouse',
                location: 'Surabaya',
                size: '180 sqm',
                image: 'https://images.pexels.com/photos/271639/pexels-photo-271639.jpeg?auto=compress&cs=tinysrgb&w=400'
              },
              {
                title: 'Cozy Apartment',
                location: 'Bandung',
                size: '85 sqm',
                image: 'https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=400'
              }
            ].map((project, index) => (
              <div key={index} className="group cursor-pointer">
                <div className="relative overflow-hidden rounded-lg mb-4">
                  <img 
                    src={project.image} 
                    alt={project.title}
                    className="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-300"
                  />
                  <div className="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300" />
                  <div className="absolute top-4 right-4">
                    <Camera className="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
                  </div>
                </div>
                <h3 className="text-lg font-semibold text-gray-900 mb-1">{project.title}</h3>
                <div className="flex justify-between text-sm text-gray-600">
                  <span>{project.location}</span>
                  <span>{project.size}</span>
                </div>
              </div>
            ))}
          </div>
        </motion.div>

        {/* Contact Form */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.8 }}
          className="bg-white rounded-2xl p-8 shadow-lg"
        >
          <div className="grid lg:grid-cols-2 gap-12">
            <div>
              <h2 className="text-3xl font-bold text-gray-900 mb-6">Start Your Home Transformation</h2>
              <p className="text-gray-600 mb-8">
                Ready to create your dream home? Contact our residential design specialists for a 
                personalized consultation and custom design proposal.
              </p>
              
              <div className="space-y-4 mb-8">
                <div className="flex items-center">
                  <Phone className="w-5 h-5 text-green-500 mr-3" />
                  <div>
                    <p className="font-medium text-gray-900">Residential Design Team</p>
                    <p className="text-gray-600">+6282233039914</p>
                  </div>
                </div>
                <div className="flex items-center">
                  <Mail className="w-5 h-5 text-green-500 mr-3" />
                  <div>
                    <p className="font-medium text-gray-900">Residential Specialists</p>
                    <p className="text-gray-600">residential@caripropshop.com</p>
                  </div>
                </div>
              </div>

              <div className="grid grid-cols-3 gap-4 text-center">
                <div className="p-4 bg-green-50 rounded-lg">
                  <Star className="w-6 h-6 text-green-500 mx-auto mb-2" />
                  <p className="text-sm font-medium text-gray-900">300+</p>
                  <p className="text-xs text-gray-600">Homes Designed</p>
                </div>
                <div className="p-4 bg-green-50 rounded-lg">
                  <Award className="w-6 h-6 text-green-500 mx-auto mb-2" />
                  <p className="text-sm font-medium text-gray-900">98%</p>
                  <p className="text-xs text-gray-600">Satisfaction Rate</p>
                </div>
                <div className="p-4 bg-green-50 rounded-lg">
                  <Ruler className="w-6 h-6 text-green-500 mx-auto mb-2" />
                  <p className="text-sm font-medium text-gray-900">15+</p>
                  <p className="text-xs text-gray-600">Years Experience</p>
                </div>
              </div>
            </div>

            <div>
              {isSubmitted ? (
                <motion.div
                  initial={{ opacity: 0, scale: 0.9 }}
                  animate={{ opacity: 1, scale: 1 }}
                  className="text-center py-8"
                >
                  <CheckCircle className="w-16 h-16 text-green-500 mx-auto mb-4" />
                  <h3 className="text-xl font-semibold text-gray-900 mb-2">Request Sent!</h3>
                  <p className="text-gray-600">
                    Our residential design team will contact you within 24 hours to schedule your consultation.
                  </p>
                </motion.div>
              ) : (
                <form onSubmit={handleSubmit} className="space-y-4">
                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                      <input
                        type="text"
                        name="name"
                        value={formData.name}
                        onChange={handleChange}
                        required
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Your full name"
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                      <input
                        type="email"
                        name="email"
                        value={formData.email}
                        onChange={handleChange}
                        required
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="your@email.com"
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                      <input
                        type="tel"
                        name="phone"
                        value={formData.phone}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="+62 xxx xxx xxxx"
                      />
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Location</label>
                      <input
                        type="text"
                        name="location"
                        value={formData.location}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="City, Indonesia"
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Property Type *</label>
                      <select
                        name="propertyType"
                        value={formData.propertyType}
                        onChange={handleChange}
                        required
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                      >
                        <option value="">Select property type</option>
                        <option value="apartment">Apartment</option>
                        <option value="house">House</option>
                        <option value="villa">Villa</option>
                        <option value="penthouse">Penthouse</option>
                        <option value="townhouse">Townhouse</option>
                        <option value="studio">Studio</option>
                      </select>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Property Size</label>
                      <input
                        type="text"
                        name="propertySize"
                        value={formData.propertySize}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="e.g., 120 sqm"
                      />
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Number of Rooms</label>
                      <select
                        name="rooms"
                        value={formData.rooms}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                      >
                        <option value="">Select rooms</option>
                        <option value="1-bedroom">1 Bedroom</option>
                        <option value="2-bedroom">2 Bedrooms</option>
                        <option value="3-bedroom">3 Bedrooms</option>
                        <option value="4-bedroom">4 Bedrooms</option>
                        <option value="5-plus-bedroom">5+ Bedrooms</option>
                      </select>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Design Style</label>
                      <select
                        name="style"
                        value={formData.style}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                      >
                        <option value="">Select style preference</option>
                        <option value="modern-minimalist">Modern Minimalist</option>
                        <option value="scandinavian">Scandinavian</option>
                        <option value="contemporary">Contemporary</option>
                        <option value="traditional">Traditional</option>
                        <option value="industrial">Industrial</option>
                        <option value="bohemian">Bohemian</option>
                        <option value="mixed">Mixed/Eclectic</option>
                      </select>
                    </div>
                  </div>

                  <div className="grid md:grid-cols-2 gap-4">
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Timeline</label>
                      <select
                        name="timeline"
                        value={formData.timeline}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                      >
                        <option value="">Select timeline</option>
                        <option value="asap">ASAP</option>
                        <option value="1-3-months">1-3 months</option>
                        <option value="3-6-months">3-6 months</option>
                        <option value="6-12-months">6-12 months</option>
                        <option value="flexible">Flexible</option>
                      </select>
                    </div>
                    <div>
                      <label className="block text-sm font-medium text-gray-700 mb-1">Current Stage</label>
                      <select
                        name="currentStage"
                        value={formData.currentStage}
                        onChange={handleChange}
                        className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                      >
                        <option value="">Select current stage</option>
                        <option value="planning">Planning Phase</option>
                        <option value="new-property">New Property</option>
                        <option value="renovation">Renovation</option>
                        <option value="partial-redesign">Partial Redesign</option>
                        <option value="complete-redesign">Complete Redesign</option>
                      </select>
                    </div>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">Top Priority</label>
                    <select
                      name="priorities"
                      value={formData.priorities}
                      onChange={handleChange}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                    >
                      <option value="">Select main priority</option>
                      <option value="functionality">Functionality</option>
                      <option value="aesthetics">Aesthetics</option>
                      <option value="comfort">Comfort</option>
                      <option value="storage">Storage Solutions</option>
                      <option value="family-friendly">Family-Friendly</option>
                      <option value="entertaining">Entertaining Spaces</option>
                      <option value="sustainability">Sustainability</option>
                    </select>
                  </div>

                  <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">Project Details</label>
                    <textarea
                      name="message"
                      value={formData.message}
                      onChange={handleChange}
                      rows={4}
                      className="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent resize-none"
                      placeholder="Tell us about your vision, specific requirements, challenges, or any other details that would help us understand your project better..."
                    />
                  </div>

                  <button
                    type="submit"
                    className="w-full px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-xl"
                  >
                    <Send className="w-5 h-5" />
                    Consult Now - Request Residential Design Consultation
                  </button>
                </form>
              )}
            </div>
          </div>
        </motion.div>
      </div>
    </div>
    </div>
    </div>
  );
};

export default ResidentialDesign;