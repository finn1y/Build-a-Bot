import discord
import youtube_dl

class YTDLSource(discord.PCMVolumeTransformer):
    def __init__(self, source, *, data, volume=0.5):
        super().__init__(source, volume)
        self.data = data
        self.title = data.get("title")
        self.url = ""

    def init_ytdl(self):
        youtube_dl.utils.bug_reports_message = lambda: ''
        
        ytdl_options = {
            'format': 'bestaudio/best',
            'restrictfilenames': True,
            'nocheckcertificate': True,
            'ignoreerrors': False,
            'logtostderr': False,
            'quiet': True,
            'no_warnings': True,
            'default_search': 'auto',
            'source_address': '0.0.0.0',
            'outtmpl': './Music/%(title)s.%(ext)s'
        }

        self.ytdl = youtube_dl.YoutubeDL(ytdl_options)

    @classmethod
    async def from_url(cls, url, *, loop=None, stream=False):
        cls.init_ytdl(cls)

        loop = loop or asyncio.get_event_loop()
        data = await loop.run_in_executor(None, lambda: cls.ytdl.extract_info(url, download=not stream))
        if 'entries' in data:
            data = data['entries'][0]
        filename = data['title'] if stream else cls.ytdl.prepare_filename(data)
        return filename
