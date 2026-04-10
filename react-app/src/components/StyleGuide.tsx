import React, { useState } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { Link } from 'react-router-dom';
import { Palette, ArrowRight, Star, Award, Heart, ChevronRight, Home, Lightbulb } from 'lucide-react';

interface DesignStyle {
  id: string;
  name: string;
  description: string;
  longDescription: string;
  keyCharacteristics: string[];
  colorPalette: { color: string; name: string; usage: string }[];
  materials: { material: string; description: string }[];
  priceRange: string;
  popularity: number;
  image: string;
  gallery: string[];
  featured: boolean;
  featuredProducts: {
    name: string;
    price: string;
    description: string;
    image: string;
  }[];
  roomGuides: {
    [key: string]: {
      title: string;
      description: string;
      tips: string[];
      products: string[];
    };
  };
}

const StyleGuide: React.FC = () => {
  const [selectedCategory, setSelectedCategory] = useState('All');

  const designStyles: DesignStyle[] = [
    {
      id: 'modern-minimalist',
      name: 'Modern Minimalist',
      description: 'Clean lines, uncluttered spaces, and a focus on functionality with sophisticated simplicity.',
      longDescription: 'Modern Minimalist design embodies the philosophy that "less is more." This style emphasizes clean geometric lines, uncluttered spaces, and a carefully curated selection of furniture and decor. Every element serves a purpose, creating spaces that are both beautiful and highly functional.',
      keyCharacteristics: [
        'Clean geometric lines and simple forms',
        'Neutral color schemes with strategic accents',
        'Functional furniture with hidden storage',
        'Open floor plans and uncluttered spaces',
        'Natural light emphasis and large windows',
        'High-quality materials in their natural state',
        'Minimal decorative elements with maximum impact',
        'Integration of technology and smart home features'
      ],
      colorPalette: [
        { color: '#FFFFFF', name: 'Pure White', usage: 'Primary walls and ceilings' },
        { color: '#F5F5F5', name: 'Soft Gray', usage: 'Secondary surfaces and furniture' },
        { color: '#E8E8E8', name: 'Light Gray', usage: 'Accent walls and textiles' },
        { color: '#2C2C2C', name: 'Charcoal', usage: 'Statement pieces and contrast' },
        { color: '#8B8B8B', name: 'Medium Gray', usage: 'Hardware and accessories' }
      ],
      materials: [
        { material: 'Glass', description: 'Floor-to-ceiling windows, glass tables, and transparent elements' },
        { material: 'Steel', description: 'Structural elements, furniture frames, and architectural details' },
        { material: 'Concrete', description: 'Polished floors, countertops, and accent walls' },
        { material: 'Natural Wood', description: 'Oak, walnut, or teak for warmth and texture' },
        { material: 'Marble', description: 'Countertops, bathroom surfaces, and statement pieces' }
      ],
      priceRange: '$15,000 - $75,000',
      popularity: 95,
      image: 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=800',
      gallery: [
        'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1080721/pexels-photo-1080721.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1648776/pexels-photo-1648776.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/271618/pexels-photo-271618.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1571468/pexels-photo-1571468.jpeg?auto=compress&cs=tinysrgb&w=800'
      ],
      featured: true,
      featuredProducts: [
        {
          name: 'Milano Sectional Sofa',
          price: '$3,200',
          description: 'Italian leather sectional with clean lines and modular design',
          image: 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Zen Coffee Table',
          price: '$1,800',
          description: 'Glass top with steel base, perfect for minimalist living rooms',
          image: 'https://images.pexels.com/photos/1080721/pexels-photo-1080721.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Nordic Dining Set',
          price: '$2,500',
          description: 'Oak table with steel legs and matching chairs',
          image: 'https://images.pexels.com/photos/1648776/pexels-photo-1648776.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Minimalist Bed Frame',
          price: '$1,200',
          description: 'Platform bed with integrated nightstands',
          image: 'https://images.pexels.com/photos/271618/pexels-photo-271618.jpeg?auto=compress&cs=tinysrgb&w=400'
        }
      ],
      roomGuides: {
        'living-room': {
          title: 'Living Room',
          description: 'Create an open, airy space with carefully selected furniture pieces',
          tips: [
            'Choose a neutral sectional sofa as the focal point',
            'Add a glass or marble coffee table for visual lightness',
            'Use built-in storage to maintain clean lines',
            'Incorporate one statement art piece for visual interest',
            'Ensure ample natural light with minimal window treatments'
          ],
          products: ['Milano Sectional Sofa', 'Zen Coffee Table']
        },
        'bedroom': {
          title: 'Bedroom',
          description: 'Design a serene retreat with minimal furniture and maximum comfort',
          tips: [
            'Select a platform bed with clean geometric lines',
            'Use built-in or floating nightstands',
            'Choose blackout curtains in neutral tones',
            'Add texture with high-quality bedding',
            'Keep surfaces clear and uncluttered'
          ],
          products: ['Minimalist Bed Frame']
        },
        'kitchen': {
          title: 'Kitchen',
          description: 'Combine functionality with sleek aesthetics',
          tips: [
            'Install handleless cabinets for seamless appearance',
            'Choose quartz or marble countertops',
            'Use integrated appliances for clean lines',
            'Add pendant lighting with geometric shapes',
            'Maintain clear countertops with hidden storage'
          ],
          products: ['Nordic Dining Set']
        }
      }
    },
    {
      id: 'contemporary-luxury',
      name: 'Contemporary Luxury',
      description: 'Sophisticated elegance with premium materials, bold statements, and refined comfort.',
      longDescription: 'Contemporary Luxury design represents the pinnacle of modern sophistication, combining cutting-edge design with the finest materials and craftsmanship. This style features bold architectural elements, premium finishes, and carefully curated art pieces that create spaces of unparalleled elegance and comfort.',
      keyCharacteristics: [
        'Premium materials and finishes throughout',
        'Bold architectural statements and features',
        'Sophisticated color schemes with metallic accents',
        'Statement lighting and custom fixtures',
        'Luxurious textures and high-end fabrics',
        'Custom millwork and built-in elements',
        'Art collection integration and gallery walls',
        'Smart home technology seamlessly integrated'
      ],
      colorPalette: [
        { color: '#1A1A1A', name: 'Charcoal Black', usage: 'Accent walls and statement pieces' },
        { color: '#D4AF37', name: 'Champagne Gold', usage: 'Hardware and metallic accents' },
        { color: '#FFFFFF', name: 'Crisp White', usage: 'Primary surfaces and trim' },
        { color: '#8B4513', name: 'Rich Bronze', usage: 'Furniture and decorative elements' },
        { color: '#C0C0C0', name: 'Platinum Silver', usage: 'Fixtures and accessories' }
      ],
      materials: [
        { material: 'Carrara Marble', description: 'Premium Italian marble for countertops and feature walls' },
        { material: 'Velvet Upholstery', description: 'Luxurious velvet fabrics in rich jewel tones' },
        { material: 'Brass Hardware', description: 'Custom brass fixtures and architectural details' },
        { material: 'Italian Leather', description: 'Hand-selected leather for furniture and accents' },
        { material: 'Crystal Elements', description: 'Baccarat crystal lighting and decorative pieces' }
      ],
      priceRange: '$50,000 - $200,000',
      popularity: 88,
      image: 'https://images.pexels.com/photos/2029667/pexels-photo-2029667.jpeg?auto=compress&cs=tinysrgb&w=800',
      gallery: [
        'https://images.pexels.com/photos/2029667/pexels-photo-2029667.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1571453/pexels-photo-1571453.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/380768/pexels-photo-380768.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/2062426/pexels-photo-2062426.jpeg?auto=compress&cs=tinysrgb&w=800'
      ],
      featured: true,
      featuredProducts: [
        {
          name: 'Luxury Velvet Sectional',
          price: '$8,500',
          description: 'Custom velvet sectional with brass nail head trim',
          image: 'https://images.pexels.com/photos/2029667/pexels-photo-2029667.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Marble Dining Table',
          price: '$6,200',
          description: 'Carrara marble table with brass pedestal base',
          image: 'https://images.pexels.com/photos/1571453/pexels-photo-1571453.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Crystal Chandelier',
          price: '$4,800',
          description: 'Baccarat crystal chandelier with LED integration',
          image: 'https://images.pexels.com/photos/380768/pexels-photo-380768.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Executive Desk',
          price: '$5,500',
          description: 'Walnut executive desk with leather inlay top',
          image: 'https://images.pexels.com/photos/1396122/pexels-photo-1396122.jpeg?auto=compress&cs=tinysrgb&w=400'
        }
      ],
      roomGuides: {
        'living-room': {
          title: 'Living Room',
          description: 'Create a sophisticated entertaining space with premium materials',
          tips: [
            'Invest in a statement velvet sectional as the centerpiece',
            'Add a marble or onyx coffee table for luxury appeal',
            'Install custom millwork for built-in bar and storage',
            'Use layered lighting with crystal chandeliers and accent lamps',
            'Incorporate original artwork and sculpture collections'
          ],
          products: ['Luxury Velvet Sectional', 'Crystal Chandelier']
        },
        'dining-room': {
          title: 'Dining Room',
          description: 'Design an elegant space for formal entertaining',
          tips: [
            'Choose a marble dining table as the focal point',
            'Select upholstered dining chairs in luxury fabrics',
            'Install a statement chandelier for dramatic lighting',
            'Add a custom wine storage and serving area',
            'Use rich window treatments in silk or velvet'
          ],
          products: ['Marble Dining Table', 'Crystal Chandelier']
        },
        'home-office': {
          title: 'Home Office',
          description: 'Create a sophisticated workspace that inspires productivity',
          tips: [
            'Invest in a premium executive desk with leather details',
            'Add custom built-in bookcases and storage',
            'Use rich wood paneling or luxury wallpaper',
            'Install professional-grade lighting for work tasks',
            'Include a seating area for client meetings'
          ],
          products: ['Executive Desk']
        }
      }
    },
    {
      id: 'traditional-classic',
      name: 'Traditional Classic',
      description: 'Timeless elegance with rich fabrics, warm colors, and classic furniture pieces.',
      longDescription: 'Traditional Classic design draws inspiration from European and American design traditions, featuring rich fabrics, warm color palettes, and time-honored furniture pieces. This style creates spaces that feel established and refined, with layers of texture and pattern that tell a story of heritage and sophistication.',
      keyCharacteristics: [
        'Rich fabrics and luxurious textiles',
        'Warm, inviting color palettes',
        'Classic furniture with ornate details',
        'Symmetrical layouts and formal arrangements',
        'Layered patterns and textures',
        'Antique and heirloom pieces integration',
        'Traditional architectural elements',
        'Formal window treatments and drapery'
      ],
      colorPalette: [
        { color: '#8B4513', name: 'Rich Mahogany', usage: 'Wood furniture and trim' },
        { color: '#DAA520', name: 'Golden Rod', usage: 'Accent colors and metallics' },
        { color: '#F5DEB3', name: 'Warm Wheat', usage: 'Wall colors and neutral base' },
        { color: '#2F4F4F', name: 'Dark Slate', usage: 'Upholstery and dramatic accents' },
        { color: '#800000', name: 'Deep Burgundy', usage: 'Rich fabric accents and rugs' }
      ],
      materials: [
        { material: 'Mahogany Wood', description: 'Rich hardwood for furniture and architectural details' },
        { material: 'Silk Fabrics', description: 'Luxurious silk for drapery and upholstery' },
        { material: 'Wool Carpets', description: 'Hand-knotted Persian and Oriental rugs' },
        { material: 'Brass Fixtures', description: 'Traditional brass hardware and lighting' },
        { material: 'Fine Porcelain', description: 'Decorative porcelain and ceramic accessories' }
      ],
      priceRange: '$25,000 - $120,000',
      popularity: 82,
      image: 'https://images.pexels.com/photos/1350789/pexels-photo-1350789.jpeg?auto=compress&cs=tinysrgb&w=800',
      gallery: [
        'https://images.pexels.com/photos/1350789/pexels-photo-1350789.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/271639/pexels-photo-271639.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/941861/pexels-photo-941861.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=800'
      ],
      featured: false,
      featuredProducts: [
        {
          name: 'Chesterfield Sofa',
          price: '$4,200',
          description: 'Classic leather Chesterfield with button tufting',
          image: 'https://images.pexels.com/photos/1350789/pexels-photo-1350789.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Mahogany Dining Set',
          price: '$5,800',
          description: 'Traditional mahogany table with upholstered chairs',
          image: 'https://images.pexels.com/photos/271639/pexels-photo-271639.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Persian Area Rug',
          price: '$3,500',
          description: 'Hand-knotted Persian rug with traditional patterns',
          image: 'https://images.pexels.com/photos/1643383/pexels-photo-1643383.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Grandfather Clock',
          price: '$2,800',
          description: 'Traditional mahogany grandfather clock with chimes',
          image: 'https://images.pexels.com/photos/941861/pexels-photo-941861.jpeg?auto=compress&cs=tinysrgb&w=400'
        }
      ],
      roomGuides: {
        'living-room': {
          title: 'Living Room',
          description: 'Create a formal yet comfortable gathering space',
          tips: [
            'Arrange furniture in conversational groupings',
            'Layer Persian rugs over hardwood floors',
            'Use rich fabrics for window treatments',
            'Display family heirlooms and antiques',
            'Add table lamps for warm ambient lighting'
          ],
          products: ['Chesterfield Sofa', 'Persian Area Rug']
        },
        'dining-room': {
          title: 'Dining Room',
          description: 'Design a formal dining space for special occasions',
          tips: [
            'Center the room around a mahogany dining table',
            'Use matching chairs with rich upholstery',
            'Install a traditional crystal chandelier',
            'Add a sideboard for serving and storage',
            'Display fine china and silver collections'
          ],
          products: ['Mahogany Dining Set']
        },
        'study': {
          title: 'Study',
          description: 'Create a scholarly retreat with classic furnishings',
          tips: [
            'Install floor-to-ceiling built-in bookcases',
            'Add a traditional leather desk chair',
            'Use warm wood tones throughout',
            'Include a grandfather clock for timeless appeal',
            'Display leather-bound books and collectibles'
          ],
          products: ['Grandfather Clock']
        }
      }
    },
    {
      id: 'art-deco-glamour',
      name: 'Art Deco Glamour',
      description: 'Bold geometric patterns, metallic accents, and luxurious materials creating dramatic sophistication.',
      longDescription: 'Art Deco Glamour captures the opulent spirit of the 1920s and 1930s, featuring bold geometric patterns, rich metallic accents, and luxurious materials. This style creates dramatic, sophisticated spaces that celebrate craftsmanship and artistic expression with a sense of theatrical grandeur.',
      keyCharacteristics: [
        'Bold geometric patterns and motifs',
        'Rich metallic accents in gold and silver',
        'Dramatic color contrasts and schemes',
        'Luxurious materials and finishes',
        'Sunburst and fan-shaped design elements',
        'Stepped and angular architectural details',
        'Mirrored surfaces and reflective elements',
        'Statement lighting with dramatic flair'
      ],
      colorPalette: [
        { color: '#000000', name: 'Jet Black', usage: 'Dramatic contrast and base color' },
        { color: '#FFD700', name: 'Pure Gold', usage: 'Metallic accents and highlights' },
        { color: '#C0C0C0', name: 'Silver Chrome', usage: 'Hardware and fixtures' },
        { color: '#800080', name: 'Royal Purple', usage: 'Luxurious fabric accents' },
        { color: '#FF6347', name: 'Coral Red', usage: 'Bold accent and statement pieces' }
      ],
      materials: [
        { material: 'Gold Leaf', description: 'Genuine gold leaf for decorative accents and frames' },
        { material: 'Black Marble', description: 'Dramatic black marble for surfaces and features' },
        { material: 'Velvet Upholstery', description: 'Rich velvet in jewel tones for seating' },
        { material: 'Mirrored Glass', description: 'Antiqued mirrors and reflective surfaces' },
        { material: 'Chrome Details', description: 'Polished chrome for hardware and accents' }
      ],
      priceRange: '$40,000 - $180,000',
      popularity: 75,
      image: 'https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=800',
      gallery: [
        'https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1181406/pexels-photo-1181406.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1648771/pexels-photo-1648771.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/2062426/pexels-photo-2062426.jpeg?auto=compress&cs=tinysrgb&w=800'
      ],
      featured: true,
      featuredProducts: [
        {
          name: 'Art Deco Bar Cart',
          price: '$3,800',
          description: 'Mirrored bar cart with gold leaf accents',
          image: 'https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Sunburst Mirror',
          price: '$2,200',
          description: 'Large gold leaf sunburst mirror statement piece',
          image: 'https://images.pexels.com/photos/1181406/pexels-photo-1181406.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Velvet Armchair',
          price: '$2,800',
          description: 'Purple velvet armchair with chrome legs',
          image: 'https://images.pexels.com/photos/271624/pexels-photo-271624.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Geometric Console',
          price: '$4,500',
          description: 'Black marble console with geometric base',
          image: 'https://images.pexels.com/photos/1648771/pexels-photo-1648771.jpeg?auto=compress&cs=tinysrgb&w=400'
        }
      ],
      roomGuides: {
        'living-room': {
          title: 'Living Room',
          description: 'Create a glamorous entertaining space with dramatic flair',
          tips: [
            'Use bold geometric patterns in rugs and wallpaper',
            'Add metallic accents through lighting and accessories',
            'Include mirrored furniture for reflective glamour',
            'Choose rich velvet upholstery in jewel tones',
            'Install dramatic lighting with sunburst designs'
          ],
          products: ['Velvet Armchair', 'Sunburst Mirror']
        },
        'dining-room': {
          title: 'Dining Room',
          description: 'Design a sophisticated space for elegant entertaining',
          tips: [
            'Center the room around a dramatic dining table',
            'Use a statement chandelier with geometric design',
            'Add a mirrored sideboard for serving',
            'Include bold artwork with Art Deco motifs',
            'Use rich fabrics for window treatments'
          ],
          products: ['Geometric Console']
        },
        'bar-area': {
          title: 'Bar Area',
          description: 'Create a glamorous cocktail space',
          tips: [
            'Install a mirrored bar cart as the centerpiece',
            'Use black and gold color scheme throughout',
            'Add geometric bar stools with metallic accents',
            'Include vintage cocktail accessories',
            'Install dramatic accent lighting'
          ],
          products: ['Art Deco Bar Cart']
        }
      }
    },
    {
      id: 'scandinavian-chic',
      name: 'Scandinavian Chic',
      description: 'Light woods, cozy textures, and hygge comfort with functional Nordic design principles.',
      longDescription: 'Scandinavian Chic embodies the Nordic philosophy of hygge, creating spaces that prioritize comfort, functionality, and connection with nature. This style features light wood tones, cozy textiles, and a minimalist approach that emphasizes quality over quantity, resulting in serene and livable spaces.',
      keyCharacteristics: [
        'Light wood tones and natural materials',
        'Cozy textiles and layered textures',
        'Functional design with hidden storage',
        'Natural elements and plant integration',
        'Hygge comfort and livability focus',
        'Neutral color palettes with soft accents',
        'Handcrafted and artisanal pieces',
        'Sustainable and eco-friendly materials'
      ],
      colorPalette: [
        { color: '#FFFFFF', name: 'Snow White', usage: 'Primary walls and ceilings' },
        { color: '#F0F0F0', name: 'Soft Gray', usage: 'Secondary surfaces and textiles' },
        { color: '#D2B48C', name: 'Natural Tan', usage: 'Wood tones and warm accents' },
        { color: '#708090', name: 'Slate Blue', usage: 'Soft accent colors' },
        { color: '#98FB98', name: 'Sage Green', usage: 'Natural and plant-inspired accents' }
      ],
      materials: [
        { material: 'Pine Wood', description: 'Light Scandinavian pine for furniture and flooring' },
        { material: 'Wool Textiles', description: 'Natural wool for throws, rugs, and upholstery' },
        { material: 'Linen Fabrics', description: 'Organic linen for curtains and bedding' },
        { material: 'Ceramic Pottery', description: 'Handmade ceramics for decorative accents' },
        { material: 'Sheepskin Rugs', description: 'Natural sheepskin for texture and warmth' }
      ],
      priceRange: '$12,000 - $60,000',
      popularity: 90,
      image: 'https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=800',
      gallery: [
        'https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1080721/pexels-photo-1080721.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/271618/pexels-photo-271618.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=800',
        'https://images.pexels.com/photos/1648776/pexels-photo-1648776.jpeg?auto=compress&cs=tinysrgb&w=800'
      ],
      featured: false,
      featuredProducts: [
        {
          name: 'Nordic Sofa',
          price: '$2,800',
          description: 'Light oak frame sofa with linen cushions',
          image: 'https://images.pexels.com/photos/1444424/pexels-photo-1444424.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Hygge Coffee Table',
          price: '$1,200',
          description: 'Round pine coffee table with storage',
          image: 'https://images.pexels.com/photos/1080721/pexels-photo-1080721.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Wool Throw Collection',
          price: '$180',
          description: 'Set of three wool throws in neutral tones',
          image: 'https://images.pexels.com/photos/271618/pexels-photo-271618.jpeg?auto=compress&cs=tinysrgb&w=400'
        },
        {
          name: 'Ceramic Pendant Light',
          price: '$320',
          description: 'Handmade ceramic pendant with cord',
          image: 'https://images.pexels.com/photos/1571460/pexels-photo-1571460.jpeg?auto=compress&cs=tinysrgb&w=400'
        }
      ],
      roomGuides: {
        'living-room': {
          title: 'Living Room',
          description: 'Create a cozy gathering space that embodies hygge',
          tips: [
            'Choose a comfortable sofa with natural fabrics',
            'Layer wool throws and sheepskin rugs for texture',
            'Add plants for natural elements and air purification',
            'Use warm lighting with multiple sources',
            'Include handmade ceramics and wooden accessories'
          ],
          products: ['Nordic Sofa', 'Hygge Coffee Table', 'Wool Throw Collection']
        },
        'bedroom': {
          title: 'Bedroom',
          description: 'Design a peaceful retreat for rest and relaxation',
          tips: [
            'Use light wood furniture with clean lines',
            'Layer organic cotton and linen bedding',
            'Add a reading nook with comfortable seating',
            'Include natural elements like plants or stones',
            'Use soft, warm lighting for ambiance'
          ],
          products: ['Wool Throw Collection']
        },
        'kitchen': {
          title: 'Kitchen',
          description: 'Create a functional space for cooking and gathering',
          tips: [
            'Use light wood cabinets with simple hardware',
            'Add open shelving for displaying ceramics',
            'Include a dining area with natural wood table',
            'Use pendant lighting over work areas',
            'Display fresh herbs and plants'
          ],
          products: ['Ceramic Pendant Light']
        }
      }
    }
    // Continue with more styles...
  ];

  const categories = ['All', 'Featured', 'Classic', 'Modern', 'Luxury'];
  
  const filteredStyles = designStyles.filter(style => {
    if (selectedCategory === 'All') return true;
    if (selectedCategory === 'Featured') return style.featured;
    if (selectedCategory === 'Classic') return ['traditional-classic', 'art-deco-glamour'].includes(style.id);
    if (selectedCategory === 'Modern') return ['modern-minimalist', 'contemporary-luxury', 'scandinavian-chic'].includes(style.id);
    if (selectedCategory === 'Luxury') return style.priceRange.includes('$50,000') || style.priceRange.includes('$100,000') || style.priceRange.includes('$150,000') || style.priceRange.includes('$200,000');
    return true;
  });

  return (
    <section id="portfolio" className="py-20 bg-gradient-to-br from-gray-50 via-white to-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {/* Header */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="text-center mb-16"
        >
          <div className="flex justify-center mb-6">
            <div className="w-20 h-20 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center shadow-lg">
              <Palette className="w-10 h-10 text-white" />
            </div>
          </div>
          <h2 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">
            Premium Luxury Collection
          </h2>
          <p className="text-xl text-gray-600 max-w-4xl mx-auto mb-8">
            Discover our curated collection of distinctive interior design styles, each crafted with 
            premium materials and expert attention to detail. From timeless classics to contemporary luxury, 
            find the perfect style to transform your space.
          </p>

          {/* Collection Stats */}
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto">
            <div className="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
              <div className="text-3xl font-bold text-amber-600 mb-2">{designStyles.length}</div>
              <div className="text-gray-600 text-sm">Design Styles</div>
            </div>
            <div className="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
              <div className="text-3xl font-bold text-green-600 mb-2">500+</div>
              <div className="text-gray-600 text-sm">Premium Products</div>
            </div>
            <div className="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
              <div className="text-3xl font-bold text-blue-600 mb-2">50+</div>
              <div className="text-gray-600 text-sm">Material Options</div>
            </div>
            <div className="bg-white rounded-xl p-6 shadow-lg border border-gray-100">
              <div className="text-3xl font-bold text-purple-600 mb-2">100%</div>
              <div className="text-gray-600 text-sm">Custom Design</div>
            </div>
          </div>
        </motion.div>

        {/* Category Filter */}
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          viewport={{ once: true }}
          className="flex flex-wrap justify-center gap-4 mb-12"
        >
          {categories.map((category) => (
            <button
              key={category}
              onClick={() => setSelectedCategory(category)}
              className={`px-8 py-3 rounded-full font-semibold transition-all duration-300 ${
                selectedCategory === category
                  ? 'bg-gradient-to-r from-amber-500 to-orange-500 text-white shadow-lg transform scale-105'
                  : 'bg-white text-gray-700 hover:bg-gray-50 shadow-md hover:shadow-lg border border-gray-200'
              }`}
            >
              {category}
            </button>
          ))}
        </motion.div>

        {/* Style Grid */}
        <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
          {filteredStyles.map((style, index) => (
            <motion.div
              key={style.id}
              initial={{ opacity: 0, y: 30 }}
              whileInView={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.6, delay: index * 0.1 }}
              viewport={{ once: true }}
              className="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 overflow-hidden border border-gray-100"
            >
              {/* Featured Badge */}
              {style.featured && (
                <div className="absolute top-4 left-4 z-10">
                  <div className="bg-gradient-to-r from-amber-500 to-orange-500 text-white px-3 py-1 rounded-full text-xs font-semibold flex items-center">
                    <Star className="w-3 h-3 mr-1" />
                    Featured
                  </div>
                </div>
              )}

              {/* Popularity Badge */}
              <div className="absolute top-4 right-4 z-10">
                <div className="bg-white/90 backdrop-blur-sm text-gray-700 px-3 py-1 rounded-full text-xs font-medium flex items-center">
                  <Heart className="w-3 h-3 mr-1 text-red-500" />
                  {style.popularity}%
                </div>
              </div>

              {/* Image */}
              <div className="relative h-64 overflow-hidden">
                <img
                  src={style.image}
                  alt={style.name}
                  className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300" />
              </div>

              {/* Content */}
              <div className="p-6">
                <div className="flex items-center justify-between mb-3">
                  <h3 className="text-xl font-bold text-gray-900 group-hover:text-amber-600 transition-colors">
                    {style.name}
                  </h3>
                  <ChevronRight className="w-5 h-5 text-gray-400 group-hover:text-amber-500 group-hover:translate-x-1 transition-all" />
                </div>

                <p className="text-gray-600 text-sm mb-4 line-clamp-2">
                  {style.description}
                </p>

                {/* Color Palette */}
                <div className="mb-4">
                  <p className="text-xs font-medium text-gray-500 mb-2">Color Palette</p>
                  <div className="flex space-x-2">
                    {style.colorPalette.slice(0, 5).map((colorInfo, i) => (
                      <div
                        key={i}
                        className="w-6 h-6 rounded-full border-2 border-white shadow-sm"
                        style={{ backgroundColor: colorInfo.color }}
                        title={colorInfo.name}
                      />
                    ))}
                  </div>
                </div>

                {/* Key Features */}
                <div className="mb-4">
                  <p className="text-xs font-medium text-gray-500 mb-2">Key Features</p>
                  <div className="flex flex-wrap gap-1">
                    {style.keyCharacteristics.slice(0, 3).map((feature, i) => (
                      <span
                        key={i}
                        className="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded-full"
                      >
                        {feature.split(' ').slice(0, 2).join(' ')}
                      </span>
                    ))}
                  </div>
                </div>

                {/* Price Range */}
                <div className="flex items-center justify-between">
                  <div className="w-full">
                    <Link
                      to={`/style/${style.id}`}
                      className="flex items-center text-gray-700 hover:text-amber-600 transition-colors group w-full"
                    >
                      <ArrowRight className="w-4 h-4 mr-2 text-amber-500 group-hover:translate-x-1 transition-transform" />
                      <span className="text-sm font-medium">Click to learn more</span>
                    </Link>
                  </div>
                </div>
              </div>
            </motion.div>
          ))}
        </div>

        {/* Call to Action */}
        <motion.div
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
          className="text-center mt-16"
        >
          <div className="bg-gradient-to-r from-amber-50 via-orange-50 to-amber-50 rounded-3xl p-12 border border-amber-100">
            <div className="flex justify-center mb-6">
              <div className="w-16 h-16 bg-gradient-to-br from-amber-400 to-orange-500 rounded-full flex items-center justify-center">
                <Lightbulb className="w-8 h-8 text-white" />
              </div>
            </div>
            <h3 className="text-3xl font-bold text-gray-900 mb-4">
              Ready to Transform Your Space?
            </h3>
            <p className="text-gray-600 mb-8 max-w-2xl mx-auto text-lg">
              Our design experts are ready to help you create a space that perfectly reflects your style and personality. 
              Start your project today. Consult us now.
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <button
                onClick={() => {
                  const element = document.getElementById('contact');
                  if (element) element.scrollIntoView({ behavior: 'smooth' });
                }}
                className="px-8 py-4 bg-gradient-to-r from-amber-500 to-orange-500 text-white font-semibold rounded-full hover:from-amber-600 hover:to-orange-600 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center justify-center"
              >
                <Home className="w-5 h-5 mr-2" />
                Consult Now
              </button>
              <a
                href="tel:+6282233039914"
                className="px-8 py-4 border-2 border-amber-500 text-amber-600 font-semibold rounded-full hover:bg-amber-500 hover:text-white transition-all duration-300 flex items-center justify-center"
              >
                Call Us Now
              </a>
            </div>
          </div>
        </motion.div>
      </div>
    </section>
  );
};

export default StyleGuide;